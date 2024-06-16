@extends('layouts.app')
@section('content')
<style>
    .navbar {
        display: flex;
        justify-content: space-around;
        background-color: #f1f1f1;
        padding: 14px 20px;
        border-bottom: 1px solid #ccc;
    }

    .navbar a {
        text-decoration: none;
        color: #333;
        padding: 8px 16px;
    }

    .navbar a:hover {
        background-color: #ddd;
        color: black;
    }

    .content {
        padding: 20px;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .avatar{
        width: 40px;
        height: 40px;
        border-radius: 999px;
        margin-right: 15px;
    }

    .post-list {
        min-width: 60%;
        max-width: 60%;
        margin: 40px auto;
    }

    a {
        text-decoration: none;
        color: black;
    }

    a::hover{
        color: rgb(111, 185, 235);
    }

    .author {
        color: rgb(111, 185, 235);
        font-size: 12.8px;
    }

    .date {
        color: #888;
        font-size: 12.8px;
    }

    .view {
        color: #888;
        font-size: 14px;
        margin-top: -5px;
    }

    .title {
        font-weight: 500;
        margin-top: 5px;
        font-size: 17.6px;
    }

    .post-card {
        position: relative;
        display: flex;
        /* Đảm bảo rằng phần tử cha có thuộc tính position: relative */
        margin-bottom: 20px;
    }

    .post-card::after {
        content: '';
        position: absolute;
        bottom: 6px;
        left: 0;
        width: 100%;
        height: 1px;
        background-color: #ccc;
        /* Sử dụng background-color thay vì color */
    }
    .infomation{
        margin: 20px auto;
        max-width: 80%;
        display: flex;
        justify-content: space-between;
    }

    .personal{
        display: flex;
    }

    .infomtion button{
        display: block;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />


<div class="infomation">
    <div class="personal">
        <img class="avatar" alt="Tlinh"></img>
        <div class="thong-tin">
            <h1 class="name">{{$user->name}}</h1>
            <p class="follower">{{$numberOfFollowers}} follower</p>
        </div>
    </div>

    @if(Auth::user()->id != $user->id)
        @if($isFollowing)

            <form action="/follows/unfollow" method="post">
                @csrf
                <input name = "following" type="text" style="display: none" value="{{$user->id}}">
                <input name = "follower" type="text" style="display: none" value="{{Auth::user()->id}}">
                <button class="btn btn-outline-primary">Unfollow</button>
            </form>

        @else

            @method('PUT')
            <form action="/follows/follow" method="post">
                @csrf
                <input name = "following" type="text" style="display: none" value="{{$user->id}}">
                <input name = "follower" type="text" style="display: none" value="{{Auth::user()->id}}">
                <button class="btn btn-outline-primary">Follow</button>
            </form>

        @endif
    @else
        <button>Change info</button>
    @endif

</div>

<div class="navbar">
    <a href="#" onclick="showContent('bai_viet')">Bài viết</a>
    <a href="#" onclick="showContent('following')">Đang theo dõi</a>
    <a href="#" onclick="showContent('follower')">Người theo dõi</a>
</div>
<div class="content">
    <div id="bai_viet" class="tab-content" style="display: block">
        <div class="post-list">
            @foreach($posts as $item)
                <div class="post-card">
                    <div class="avatar">
                        <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxMSEhUTExMWFhUXGB4aGBgYGB8eGxcYHh8aGB0dFxoaICggGholGxgXIjEhJSorLi4uGh8zODMtNygtLisBCgoKDg0OGhAQGy8mICUtLS0tLS0vLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS8tLf/AABEIALABHgMBIgACEQEDEQH/xAAcAAABBQEBAQAAAAAAAAAAAAAFAgMEBgcBAAj/xABNEAABAgQDBAcFBQQGBwkBAAABAhEAAyExBBJBBSJRYQYTMnGBkaEHFLHB0SNCcuHwUmKCshUzQ1Nz8SQ0NURjg5IWVJOio8LD0uMX/8QAGQEAAwEBAQAAAAAAAAAAAAAAAAECAwQF/8QAKxEAAgIBBAIBAgUFAAAAAAAAAAECESEDEjFBE1EEIjKBkbHB8BRhceHx/9oADAMBAAIRAxEAPwDH8Lh85Ycbf5VjQldEVjDoXKBU6AVyy2YHVm7XdfvinbNSqTOcXTmsOKSLnv8A0WjR5W3kCWkiYEqAsSPhGM7NIIo5w4BNGNfD9F40XpX/ALPk/wDK/kMBNpYzC4kErUmXN/bTV/xAX+Pwg10s/wBQla1l1/hPGK0uydRUjNMZeIpESsXNTmbMHaz1hpSYl8lLgYiWNqzcq0kpIXcqS5+4zHQgSwBTUu7uIqhCFQnFPkUlZ7a2NVNCM4AKQQ4oC5ewoGoA2gA0iT0b2kJWdJXkzFDU3XKgFqUWoyHb0FwR0+0MFLRWxOO0hrovmI21JEszVIMxKplQhVGSE5TlUN1usdxQHNrWAmK2tMxCCrMEpFiE6jKDrcm5scwDWAr4mBkgioNeAFGYeZP5xN2lOzS0dihIJDZizgZtWI7w40ZozhoRg8EbaLZ7OZSlJmTlF94Sx/CCovTisF+LxaNoBpM//DV/IYq3RPbeHw+FQhRUVFRWoBNieBJ/ZCYLDbMvES8TkzbspROYMKpUAzE1pHSiij4e0PS5Yrz/AF9PKESBSHgIkZ1oRPUQkkFmq/dw5/WFmETZYUGP+XdAIBqWSXPEuf13x2asOwEFUYBIUTodDoeUKVg0KUd8JPBvzrBTAGBTJcXdvnr4VgvgUKSpazdbk3oSSaPcVhf9BWqCO5vrChIWhWUk5as+oBYfKHTXIIAzUKG9ZT3FCFCr0saQdxm2fepipylZZi2KxoVBKUkh9CQ7c4E4igKatmvp3d9YZw6KkNo71pfhEtWWi99DVjq8alTsqQUnKWIBTMt5RnSElVotuztoiTIxYpmVLQhFakqCkkgHhmJgBgkMSQ1Eln4s0HCDll+9qWBGFw+z5BGcowyhnLAAqUg7oHAlqh6pqS70bZ2KSJU1BSGIBckgjeTQNcNUjUgVDV0/20y0qmyEsP6kgnUMUlPk584yTKASBUfGEmEl2d2nhck1aaMDocwY1DEXHOCfRVcqVipa55eWAoFqtmQUghuBU8KwcibMkTQD9nLQVEliwdOVIKiCAVBIYasGJIiPs3BGasIBAKtSCe4ADUtyF3IEVYkR2dSQVOVKJUQHfUlufOPbJxiZRUoy0rdCkgKc5SqmYM28A4F7+StsYJUmYEkgunMkgg7pdjukgW4xEBIDm0AmO9aCVLUXLsAeBepGunc3dCZWMyoUlk71y1eP67zxiPlAuW5fXhC+uy9nxJqfpAIcQCA5o9tHfWLZ0FLYhQJcdUT/AOZH19Yqc/FLmkZ1kkBg9kgWA4ARY+gSle8qBf8AqleO8i3GFQqIc2YQo1LVDPy7yIsEhLSwW04fSDC+hkmYv7HHylpJd9wluSUzCfPL3QcV0PSEACao6OEJHxeFtb4NrrkpSFskVaguCBbi8Wrpdik+4y66o5jsnUR7G9DElNJ0ymm65tZgw10iN0wkqTg5acyiykC/BKrxUYuJE5JlOn4DrJYmJZdDmS1UgKUHFCCGGlvWBJwyHoG7i3wMSsOoigSxD7wJCrk3Hf6RKnJEwlSiQpr3BP7z1fm/hEZLTQJVJIstXjX4iEFKv3T5j4PFj2B0VxONK0yEoJQAVFS8oAU4DUL2MHE+yzaB/wC7jvmn5IMK65HVmcz3YuPWPCQSgKala9140lXsgxpDGbhg/wC8s8/7uJeD9jmISCFYmVU6JUaa3A4CHvQnEyjJ6RLxGDAlINcxpyuY1aR7H1uonFIGlJJfSvb9PlSJOJ9kRWQ+MAbQSP8A9IW/IKJj6S1IsXRb+rxn+D8lxoEr2MSm3sXM/hlpHxUYKbM9l+HkJmJE+coTU5VE5AwZXZZF66vD8kULazGpCaeJ+Jh1o19HspwaR/WYjxUj5S4kyPZlgQaicqljMbh+yBC8qDYzF8scaNxHs42eP7JZ/wCav5KhX/8AP8ACP9H0/vJh4cV98HlSDxmGtA/Fds+HwEfRsvoRgB/usvxc/Ew9I6J4FKi2CkFwLykk66qED1f7DUD5wwM0haQlZAJDh6N3RPGNKlKKm3CQNKAvXyj6JRsLDhsuFwyG/wCCgn0Ab1h5OzJQI+zl60EtIHwhedh40fPcvamFmllBiTqLm1038YrycKetypqyynjRyly3KPqxOEQLISO5I+kcmoZmpUehglrN9DWmkfM+1diYhKggSJq/vEoQtQoCkWTeqvSPYXotjFs2EnsTfqV/SPpyvhHkin5RL1GNRRk3SbYuNxa0L91WpRlsohkgKrYLUKU4+cVU+y7aSi/UBI/emosO5RMfQ8iWyRHcnOHb5E64MKPsnx6ilJMhCH/vCSz9ogJYkDR4J9HPZdjsOta1TMK6pakXmKbMCkkDImrEi+sbDlrpQH5R1UFsMHzJt3oTi5QzmXnDOSg5ntowVblFZQipAD5ElR5MNe5TR9IT0Zl07KQ3oPoXjNPaYAZhr2cIVWvmny0VOtD6Qac28MJwSyjLo6UGFKEJCzaNzE6mkWroCf8ASVf4Kv50RVRFt6CyCjFKB/uleO9LqOUAAspHCHJE1SOwpSfwqI+BhqYk+ulD5vHJIU9eXnrHMe4+aaLDgdo4sJznGLlpJYFaipyL0U4AEIx21cVMPUzpgWHzDdTWhYgpAJF4e2Y82XKShWVUtSsxDOAQpiyncFwLcYbxiUidKlprkQQfIs/PXxj0Z6cVp4/n/TxvJJ6jTXvoGImAO7Dvh+XMSbEecCtoyHW9PERGSgj7iD4Ry2FG1exZutxX4JfxXGopVQUP6rGOewIfa4zdbclW75kbECT/AJRhN5NEsHVFmpbu+sdJ5fCO9Zoxjy18AYHwBHXNuAknubu4x3MQHIp318YSlJJfKYfLt2T6fWM4tsp0JSotYDvhSUKo+XweG5K1H7pApdvrEkq4xSzySxpaFcR5GEhBzA0NDy4d/CIeA25KnzZsmUrMqSWmUIDuQQkmispBBbWnGCClFxQ+n1h0gtnWVanrCTLLg0t+tYcBrYxxSXLsX76eTtFUhWMplkGpBfl+cLAYs+nD4QtST+z4OGhBd6j1iRnVSjxPpCDLNA59PkIdJP6McUVcBCaQJjapbC504ce6EmXbeJry+UdmZyaJGlX5wLTtR8SvDTJSkqAC5Zd0zU0dQIFCFOCDwEAw31Y5nxhKJAYXtxPzMeTMPAef5R0L4NTn+UXgnJxEkDj5n6wrIIDo6TSfePditPWGgYHLmvlKrZm08L0gwH5QWgo9lHKFZaRwPy8vzjsyx7oAKTMkjOslAYmjG4D0UPH1MZp7RpIE3EirDDSh/wBWJBLf9HpGpySSCXSQ/dWnM8ozD2jkhWJ4iXhU0sXmTl05Uhaf3FT+0zJSPKE9XXlDyhDmGUoLSoaGOg5yLMkkEBrgEdxtFp6BpbFKH/BN/wAUuAvV9diEpNHNciSS9VFkpqTXTlB7oNh1JxSyQw6tQ4WWineNYYAEYo8BHfeTwENokrdsin4ZS40te8S0bLnn/d5//hL/APrEbUdC1tT2xCFkkNQxb8B0eTLmznWSZSAez2isEHWgEAsPhSksqWtKgQ+ZBGWou9vGLxKf3yeBqlI+MN/bRPkld+zPcSN4wwUxJx7iYsNYmIuY8Iga4NV9glJmM/BK+M2Lp0u27MlzsPIkTpaFzCc5mBwAaIKqEgFQUmmvdFN9gvbxhNN2SPWdF26YbGXiTIXJXKC5KlEZ2I3gA9iKM7EX7ozk8joCT+n6s+FoEqC1DFJAcJZQlljcCpVfVIrrL2z0kxCJe0ClYzSJ0tMvdFEKKXSeIvetTWzB09BZUp04rFJecMkggFjOU5Oe7iwDkO/EiCyuis6Zh8VLXOlFc/qlOCWzSwMzm9ct+cFoVEDE9M583FLw+EmJUJqpaZKyj+rGUmYQClyXBuD2S1xEnafSzFYITMPNInzylJkTAhswUSk50UDgijXcPEjF9EinEzcVImSpak9WqSG3UlCFJmJmJH3VCrit4h4fo/MxqZmLnz5XWqCfd1S6ol5C710JDNUipNSwLSHRYOjgx0uYlOJmypyFCqgMqpatBupAUk2iq9Del+JViurxE7rZZEwqdABlBAKgrMlIcEBQasWbYR2gqf1mJXKRKSlhLlMRMV+0SXUBrcaUEVDEdAMZVKVSAEqmFKnIVMzgJIUQl8raHnxhRfsGiRszpzNTh8VMUkGapYXJdAG6tRQAWAzhGWhNTZ4KrXtXDSZk2bPRNBkzFKokKkLCCUqTugLZTAjyEQdqezluqOHmkNSaVkGrApWkAAMFCo7miViZO1MQFy53Uy5ZlTEEIUlpy1JKQS+ZQDl6ZbQOS6BId2b0qVNnbNlpnBRWhfvKQB2xLBGajpOYKNG1iDgOkuLn4j3VM7KU4iYpc0pTTDoIAQAQ13D3qmtDE7ZPRcy52z5qJaEGUhQxDMFFZRlBpRdSqr6w3svo/icNNVPQEqWqdMExAWPtMOvLlUHoFJU5ahv4ikgaIUnpkv3PCKOJHXnEJ6/s5upzLfMlmAy5agDSJGC2ltTGBeKkTJcqWCrq5RAOcJNlOkknRyQ5dmER09CFJwmFBkp65M8Gec1VSs6nY2Iy5S16caQ4F7QwUpWDkyOtS6hKnC4Sok7wsFBzUkAHiLjmugo7t7pzMVJwi8M6VqBmzUgAsmWSkpLjsEpXWhZIiz9LNpqTgJk+SspJQlUtYvvKQxD8j6xTOjvs+mLUtOJWqWlCQlGQg5nJJYkdkPZquYOK2VilbJmYQo+1QciC4ZaErSsFNf2XAB4RVp8Cqj0zpR1uLwCJM8LSpKxOSmxXkcZg13BoIhyek61bVUnMfdyeoSW3esDF34laWZ7KTDu1OjC5E3DzsHIAKJMzPX+1MshJOY8TApfQtUrDImJmr96TlmCWSnJncGhapAo71Igddgg17RNsT5Hu3ULIUpSiUpsvLkICuIqfOGdpdLgMTKnS1KVJ9yVN6t6FeZQSFcDmZJOkFds4WbiJ+zpwlkJQpSpoP9nmSggEGtwR3iAH/YmZ75OlgEYZcmYJSqFKMxCwjk0wqLcBzhIBGE2NtLEI98M8JWoZ0Ia/7IysUppZ35xNwXSFWJn7MUCUZ+uE5CSQkqSkXS9R94Au2aEp25tKVKTgxgyZwTkTOD5WAYKtlcDUqA1bSH9mdGJmHn7OATmTKTOM1YsFrSaVqzsAW0gAvdOcImK3TexrC3hMyxrpBYimTMUAAkUrqCGFHJ53p8Izb2gnMrEEMxVhQPBOKU3wjUd0EBINWcu1XVbwbvYRTumXR9U0TlJSSCqXMUMyewhJlily6lkNc6QafOS5q1gx7FgDKkMGGmt6mGwnhprzjQ+neEIkSs0rKxvkarKoC3DSKzhuj8+YhMxEmYtJVvBCc2Vn0S5D8CKU4xvB747kZ6un45bbAcqaQsrDguWbTzi09D5S/eSo1SZSmNWfNLKr61HLvgYjZ7pUrMJalTFtm4Jox4bxPlFk6H7OmiefvJEpgp6GsvsvRr+kUrM2WaT0MlCapaZkwlTuKM5L6J5RYQ4N7QzgtoomOqWoKANwQR4Mfi3ziQ4rUPDenF8oFJrgAdI9kFKJ04k/aKzs1KqTQatHdjJJxONZIV9nLof4mbhBbpdOK5CkuCyUihBFxwgHhcWJStpuWPVS24uOst5iM5pKLouGZIrGHwCZyl5hQB3FxVUDNobDVLUcu8AAeYBe48DFx2fsqSZSFrTmKkhRZSklzUsArKQ5tQjgYlf0JhlB0u3HrF6UaqqMXDRzb2mdGxcD3sIDHG2/sf8A5o0LG7clS1TElyuW7pDFSmQiYMqXc5s4SOKqc4AeznZ8uQcQJf3jLJq/95B3HbGlTVOsEgzBMIoyiAhLKDVT9mktxEKUkyKyR5/SXDKoQpTTJYAASSVLl9dLKd7llfRXKsSZW2EKUpGRaVpyBSVBLpVMUUJBZRGgN7KBiOeiMgFJHWDLMK0sRukpCQkU7KcqCkG2VrEgyZewUhSlmYrrF5SVEJ7SFmYgsA1HytwAtBQWgcvpThQlSjnpMEsgIBVmKcwYPVJD14giHjtjDyc0tCCAhBmK6tG6lLCYolm0WDQXMI/7HSnknrFFUuaJjkDf7JKVDg6S3DMoaxGn9DxkCEzElhMQ60FRCZjMUsoMtKUpAJcMLQnSBZCUvpDhxQ5goZQodWp0qWcqAqlCq4e47w72G2zImCmYHMEgKlkEkqUgMCKjMhdRbKSaQGxPRhRIyTcoEzrKpJWS4VlVMzOpJISGL0lyjcF5uE2PlXKUVZuqVNINf7RRUNaM5HibQnJFbSZP2xh0vmUaFnyKIJBykIISy1A6Jc+UKRtLDhQzKSl0Z99JSQhlF1ZgMtEroWO6qlDAjG7DmTEokZkiVLWFoU6s5YkhJbsslShmBcljSoMna2xZkxaBLUEoygKWVLKyEZlJSsEkTE5yk5iQpLLY71FGrBhCZtXCADMUitAZagp6fcKc1XDUr4Q7KxuGICwuXlKlIe2+kFRSX7JCUqJfhATbez8ViChZShBlKcJRNOYgFCi0zIGO6WoG8Wgevo3PUlLEDNOXMmBSnuJuRRIG8ftMi6bwA4RtviRtZa5m18JlzKnSsuZnJF2zVfkH7oexE2QgnMqWkhOcuQGR+0eCaXtSK7tdeKmFExMqZL6tV0KlGaoZVJpnGTI6gzl6mgiFtjZuJmrnzU5SVpVJCGGYySjIN98oGc9ZlZ710hOcWCiyzzsdIQrKubLQTUBSwkqGjAm0SJuMlIVlVMQlQDlKlAEDiQTbnFSkYGfKxmcyFzpQw/VS2KC4Ks6QvOaADcJrYHWJuM2NNEpCSCtSML1eYAE5s8okJep3Ulnu0KKBliGKlMlXWIZVEkLDKNmTXeL0pHpuXK5YOW7WoNdbhj5corqZaU5lzpKpwmpCUA4diQM7yyi0tzvOWBzO9IH7T2NOmSUIKSpBxcwqlFDshSpwzFQLkFChXnFWhUXFSE1qXF3Wad9Y6OL+p+sU+ZhCnEL95SVSUIQgrUkqEzL1ipa1tdgpQU9M5egIhqVMCJk9MsGWiZKSnCgJUlRS684lU3CVBRSKNnQaOIkqiyTNiIOKTinVnSgy2csQ5Ne4m0ExK737zFQxqUN/oYYM2IMoKH2OZOYEAP12XMR98DPYkOzhZiHme7ypYEpBm55M3PLK0EFIWMoAWtOdNCVBJU+kSOi65LfnDONR9mprsdTDey8MUS0uoFanWs13lq3lEcA9ANAANIexpZCjQ0hsS5KvJkVzDM4/fU3CoUT+jGf7X23Lk4vFgy8QpUxIlrUjEJSlgJawUJEospOUByT97jF5n4ZUxGVS2GoSopzd5Afk1BcnSMu6Q4BczGYgy00ExrtZKQ1axWnKnkclawScftWViUBM33pSUkFOfESyEnsgkCSCb8dYpM5eZYKRvkBzbL3ataD8/AzZacyksHSHcH7yWt3QHwqRlSdS3yjphVYMZXeSRtPdlyBmO91pficwBveoZ+RjReiCg4B0lt5FMZ1tGUVCSP2QojkCrNX1i/8ARle+cpT2NTo6eEaw7MpIpkjpIvD4dSAwcjKQ4UCb25C9x5QZwm21f0ciaF/a1TvrJKiCUkgE7xtenGM7xjggKJzA1fjyHhHTiVKU6qlmHIchpeJTKaNc6PdIJUwSJBCzNKkhRJBCldpRUxJahZwIH9MVS14+dLCigTClNLlndhFZ6BrzbQwoUgpOckEu5BSSKdzl6we9qZCdolkA5jqPNtP8ohrNFJ8AGdNnySJecKo+UvRNgCSEse6Ig23OqEqIAJc3uSePOJeInZ8ucOQnKHuw1fm9TrAxOFQS5K27gS/AmEoplOTRsfsOxC5kvFFZJ3pbEjku0aXNTyF4yz2EYXKnGOR2pXwmXjUzLDWjCazRSYsSxwjyUAC0eKQOI8THD3mDC5EeMkF7+Z+seMkc/OE5iNTDiX1Pw+kH0sMoZMkcT6fSEGR+8q/L6Q6SrQjy/OEKUeXlESUSk2e6pqg/COHNoR5fnCnUOEcJPLziaXQxsFVXI8vzhSCp7+n5woqLWHnHM/KJ7GcLsbQk0L08z9IX1h/ZPi3pWOk8j4RTSEeC+GkL686iE0ezHujhUNaQ02hC+sB0MJU373gfzhBUNFCFy5gLVDw7ChaE0Zj8/GEzDW3xhzNHiR4xQhpEx+PkY4KPRnraFgiFBQ4wuRnEqhjHrAQp6BqxLSaxG2wkGSuptpeG44EnkqKNopKTQ8AySXPc3GnhFMmOZ89WU1nK+AAoe6L8khhqGo/Gt/L1innYSZs1a885OaaoN7vmQN8porMKUvEKN8mu6uAB0nfqGZiVp+LxTUdkPoeDaxp/SboUqRhZ85WISsIlk5eqy2GhzlvKK5iui0tGykY0TFlakyyUnLl31JHB7F7x0aaUFRjqPc7F7Uw4lS8DOypKZmFRmDXWBmJJFiQtPlDnRLG/aqBKTuEjTVPPugtsaYfdpAKFFpSG3qdkaMYJbLlAzCTKD5TpzHBnhx1GnQSgnkzWZ0RUSHLOBmsa8qx1XQ9z2x5N8IdlSJ/3QR3SvmUiHBg8QbmZ5gfP5Qt0vZTUX0TejXR5OGxUnELnBkKchuRTw5xL6cKk4nFmcmanLo5D14gu1PiYFDYqyatzdT/L5x0bMy3mADu+phbu7DavQyrDSEiq3PJj4dgfGIcwB91D8yz+kFQuSg1nJ8Aj5B/WHP6WkD7xPdmNfhApsHFF49icotiyUtWU3/q/lGlltfmYz/2R45M1OJyvQyxWmky1Y0C+sRJ2KqOACFNHiO/0jhobxAHD3wkzCOB8Kx414eIjgBb7vKFfoYpD1qC/pHl0uH/XOEV1FoXUi3wf0MF2AgzDwPp9Y9Lcmx8xCj3HyhcpWtvAw0shZ6Y/CGgrjTvESFF9fKGlCsEo0wTG1zg9x4xxCw/aHdCzTj4RyWkPVojNjHARHYWJY4DyEeKAY02smyPOuP1xhJSOUPKlJ1p3k/WGZmGTdJVf9o+kQ4spNHDJF2HlD/VDhDKZH7yvP6iFmUf2vMD8oaTBs8ZA4QtGHDVHx+EcTIVxHl+cPJcCw8/yioxzlEtnAGsD8vWIe1kHqiMxqRUNxFnETOuqzesQ9qzvszQ3HDjFNqgV2VuVgwSc61qCQ7BZ4i+Vnv6wvo8qYMwUk5SpZSXoE5lN3HiO/kYSiWu5KRm5E0d6mg0/zibsZZMlBJd3qdamFDkuXBC6ff7OxI4yyPOkUvbhbo9IHGXh/wD2K+UXLp63uE0Wdh5mMmxu0cXNwacMZaUyZaE3DEhCaEnNwD2jZGZYtlyh1Mr/AA0fyiDew0pEwu7ZTbvTAvCIZCPwj4CCexhvn8J+IieyujN1dKJ5tkT/AAv8XiKva2JX/aK/hAH8oEFU4WUkdkf9IJ8NYkSgQSwylN7BXO54PCc4RVpCal2yvKkzl9orP4lH4ExLwvR1ZUnOwBNa1a+gPd3walzFISXUE8wAVZqkAHx8ntE9OOAAJSWoSVEDk9w9XteOTV+XNL6UYPUA6uioYtNBNSE8U8A9++0cw/Ry2YMNS7tbhR62pBdGKlEqZZoXVXs1duBoPQRFwe1jMmZZaFLyhif2asM2ji1OFrxhH5HyGn++Bb2Wr2f4uVguuSsK38hcNRs+jvYk+Bi7YHpNh5hy58p4K72uHFy13jNpeIWazMqS1CFvXnQaPX0hUmYsHtsAA4Y8AR927H5xgvl6qeaKWp7NW99QFhHWDMQ7Xh1Sn+8H4coyVeKoCFZvNI4gAgEvbS3lEz31RZRWQGYGrtajX0D8qc6/rZLmJp5EaWohNVM1nJ1MPpUGtGWStqTVknODlAq4UgUKaMC6mOv7WsF5W3p6HUd+zJPDWrAmjaAPx0pfOjF5RW5MvhWGIjvWJ4tFUw/SVZd5adNaGlR3v8Ycn9K0AUSQQ96Bw3nfiGjSPz9N9jx7LNnDisPPFIwXTNKu0kK/Bp33Fn8ocHS4JIKwnI9SDUJOpHIQ4/O008/oLD7LpCVBOoHiIBSukUhSiMzAB8xLA+r+NqGCuExCVglKnDCj1Dh9aimhjp0/kQ1HSYbTs1AezenwhAA4+p+sIRjJSlZQt1EOGrQcwGh3Jz+HrygUoy4djFS34mO54RNIQlSlHdAJJawF4Ey+kmHIcLGrjWjaNzEKerGH3Og5DWc8vGOTHMR5GKCiQLi/6/XrDqV1sfL6RSmpBVHWWOB8W+TR0ldsvkR8IWlXeO+FqPCvKLSsVniYb65ufP8AWsOpiMuYz950+kOToSOzFAn9c4jbRmASyTYfrWkSUroOcRdrKyyyeY+MZv2WgEZr5cooAHpR9N4nS9H1iZsgNJl/gT8BESVSqjwPiSAGfvibsz+ql/gT8BFQHIE+0RTYGY13SzB9YzzHlsNMPCSr+Qxf/aQpsCr8SfnFA2n/AKrM5yVeqDHREyfQflJYAchBDZA3z+E/ERBFIIbJU6z+HhzHCJ7K6MrO1g/0ifI2kCmqkBgTcEuXNnd+YtSK/Kwi3sfP6RP2fg3VmyOAaMq6tKagUe2nOMtSEXHISl9LsVLlrXMSneDiruA3EOODVHlBVUosoSwxfdZQA4EVcq0Jo/yVJckLAdI1PZIJc142qePNjKEwhSd9lFlUIfKGDgEEAOohga5RUxyzkYxjWRlBKkhlAEOCQRxZ3NSTSxsTHZk9OYJzKQk9nKpLtQ1AowD29Wq5ipACQCctaBwAACkNZlFm3XPavET3QKUFqQ5SEKAPEdlyWNCRSw53OaSeWQ1kmIxynOUOBqe0Q5ANmJFn7ms8Nrx0wAFSih33yC5FS70qwN2Yd0JTlzq7QSxKlEjhkBIG6kDiX0vDOJypCSCUb3aLEvZrhnFyb0eJUI2sD2VyTZZAJLmjBKy6i5dTl6CrnM5LK5w7/SEuW7JByskDNQlmcs1TUBxU17h+MdZLK6xa6AFTJY6hnDEBgTzoXaGcZhU5gAAnMnMTVy7Vq7fwkNRmeF4k39RnlFh2fj2lDMgSdcoqw0ORJcBiH1+MI9+SvPlWo9m54hjkFOVS4BL99Xw2LVvqClrUoXyhwxSSoGwIcG+nKJeNxipaUokIuN4iWQpIUS75ia9oX07oT+IlL/JpYTVj0rKRmKQCxFzmILFVHAoRqad5j0rGBKVKmFSlkgAgPzASkivloLQERglTWQmYUgggaBw16szA01OuomScLNbq1ly4YpAAYsVFj2jU01YmlQKejBKrJt0E5O0khIPWsxfM1gBUJbmLuLRO2ZiM6QApC0PvZkkpZnHa1dqOS57gQWJwSZSgopmTVhYZyMucgJBNAlnX2WNVEd7+CwyZDBSFDKkJWoKZRJdyFBgdU0IIpfTGelBxuL/QtOixZyArOCOJSKBIIagA5g1ZwaxyRiFS1BaJi3DZUBmSBU34ginMwBxuLSySguUkoDk9pnLmpSSXIF6VJcQrCzyFJzhSUoKnLKDmoG8sUUFaUG9GC0HVj35LT73MQMyQUsXIuzOKZXCaPXnHJ22puVXWLUoPQ2ra5Das4oYB4ba4IUQSQ5TXwIyhICmYXLjnEfCTVFRXVaUuQNa1SLuVOk1BvpQiJjoySaZTn6LBJxi0OMyywYilgLEa2B8uBhgTSQ7pSCXLoLK1c1fg3na0DFbSCAHSASSCC7iwGtam5vAfGdIFrmhJCSQuvDNugAv/ABA91a1h6fxpzeEFsueKxmIC86CVKBADMC4oApyLDX/Iy5XSbGImBS0pyMxsxOm64PiHfhFek7UyqAXmSvKAzujKSGNqhiKjuq0QMTtdQJzoIDdqlAzgvoWFa2pChHWTx+f85HKZoUvpfMWKJQku+pZGut31/KAeJ2rOmKKFTZtyUFI3QFOO0L0cVNOFYqi9oKKmAJKQMoUKkEZ8ywk0UwpR62NolS5yRvBRCXAr94jgSLks5HhW+s/M/ukTvNVwe1pIkpUpYQzJVV2U3mbGvIxXdr7XX1qihZCUk0r414UPo0VFYUrKM+QEuGAJLVAFqOGfuobw9MmqBokMbljR6VpYXb6wamtqTio3+Q/IXzZW3utUApCpZI1qH4O3fE3bM8dWQVaimvzYRkk7awQrOpedWgSxym5rcXqoktw0izYzaHX4IFBJXL3Sa2VxNjVidRprHTpamrVS/A0hOw1NxMuUpya0NXJPBnJYQS2OfsJX+Gn4CMxGNmKusAsEkEANxrmHIjxpqLr0X2ZNVLRMM5SQGZAfKQP2hmN+NL21PRoakpTpoS1NzoR7TP8AUVd49ATFJ2mPsFj9xvlF09pslXutSGcmhNbAuO5UUra5aTM7h8UiPQiKQdUkPE/ZHbP4fmIgA6xP2R2z+H5iEhsXs/ojhJSAOrCz+2uqifgO4CJGL6OSJgbKaWYs3k0TU4pN2Pl/nHfehoYMMGgHiejALMrstcEu1akkmtPyiDi9iLCnQEgkWHAU4ggfCvGLWZjw3No2tavw+kZS0YPoblKSplExWyphZ0k0Lljz4VIr4vxu37gR/aLubkgnjvGvCoa1Gi/olAl25U/VIUMEgGoSfB/1+UYv418MSjHtGeJkJQkhIOY2rRgNTwsb6wkSkiWxyEhzugkcN0rDEu+lu+NDXs6SqplpA5Ur4RFm9HZJsCNQH8KxL+LL2NtcGXKnzJjJQhlEOSHAXoGVqOXIjRyjZMmYoLVNSqgypB4HM9QQxABryBBBvok7oykUQpu9Ot71OprA7E9G5iEkZs/CteDmg0IHjDlCUU0kZ7UkUmWoielO6hS3FAGYkElrCjefF4mSZVQkq6xkOAxS9fvMDmAZi5r8Tv8AQ0xP9meBpm9Q96DhV6xCRgl5knqtd5RLFL0c1csHLM9U62zlufRMtP0RZaFqUFLSkAkO6my0olhdybBuRhGFlqVlKlKzOoWUnecMLUBYBgSbaUCpuEmJUsqzNWxcm1iXYUPifJ3Dy1SwXQp1JCmOtDU5g53gWT+6dAYVUv5+5UIdUcklcuSl1glyCVBhchzUUdi16jm0zDdW7BRUQMygl7ihqGARyHBIaoYYrCDMokb+eyagAORmuKK48q2jsvZaXCi7vWg3hpzaoqb0PGIlCL5ZDy8jk+eBmQVArUC+Y5mD5iAlPaLhwwHFrmIuERnCM0wJl5A4dVWYMugNnN9TpeX7sQosQht4EAO7BLsczjKkeQ8EnAkKKyDUuCFEEFJuU0YPlNQeZu7VVhlQ03J0I2pJl5kzJG6aoYhTtZykB1Kem9QUpeO4vaErColIyhRA31pLnOwqMwzWDAcCIXhJagetUSQxBAJddFrBJBZ243vSGdv4PPLZlBSahmpc0qBfQlmbviowTcYydo12JIgqxMztEAAgGhBTcsHFSwSbkhyebKkz5i5pchKVDKChN2Lhg7WJ1uOMLnLUs76S60KU4Y7ySAMzJqXU7WJeCGycMghS5oWR905mBubnvYXsI0dLmkYyTvg7uLBRmK0AJKio76qk0DE5GDG/heIy5ZQcyd3NVswdAJKgkhy4bLStGesEpmy0JGVAYPUk1Crd9srkvfmYjyNhqmTCkzd0F1EghmNgCXJJzM3N7h8aSvOCvDJ8A3ItSgxLBi7UewOrkuA7+YESglmSn7RQUXJNQzigCrhwD3w7NmiUHSkqKmbjRrA3q7gm9NI6N0CrG+od2UQkvU0IfjZizU3YRiuBW+F5RR2U5UXGrkB6uRTieDxClGasFVgs7yVBqbxJLDgEjKASX5wRWFB+yQQ5FcoYmhKVA0FTX5w3LwwVXIo2beerlRIAAy1yUqHZnaIjSVg9PIzIw6UKcUYVUq6WAJI7VNNCfi7J2wUg5aPYEBmI3VKq4NFHjeBk6XmBS5yihBV2maiCGGjtxtQuH1YMTJjIRQAIOdwCUpyVrrlAzDkQSYpwT+4zeB+djOttKzV3zQBJqDXUkAh/SNE6E4uaqQHL1LPwt8QaRQNk7NOVSEICyyhvUOYsN1i5FBQ+hUY0joTgZ0mQAsJc6VtrccX+Mb/HSvHCOqG1aTfdpfhn/QE9pWMUUplmwSo95UClvKsVzayXkr/h/nTEvpjtBGInTFIYpBygjXKMqmOocOPPWIm1f6o/iR/OmOyzOgxgKy0Pw+FIK7JG+fwn4iAuysUkpTLD5gK0LecGtmTkCYQSxym7jUWe8SnkroHDCoHZzI/CoiHM04dma44KA+kLB/Rjprx8vyhUULlYqelitCCP3Sx+Y+EODbiAoO6XGoB823h5REHJ49e9eXOJSfsLQUkbVSo0Wg8nb0N4loxqTUg94t6RXlYdBugeTGGfcAKpWtPJ/pDthSLhJxAVqKen5x00N6m3h8g48xAbY+MEqVME5alFVKV3WIpqDU15iBMzbYlryy86kUqoVFTR7qFRcA0udK3E7S1NWh+vjHcyVUvWpHL0rygCOkCEqyvmDPmCS3mrKSfDWFy9sylWKQ+j5fQiFuTHsYZSN4mrA8b/AK5wiaMzBu/l6fqsNSsUGs3k1daRxE8Gn17tYaommenSJavuB9CzV7xEJWypRIASQ+o8TrzA84JoWNPSscUtinvp5G8DinyHAFm9HU0AWo6VZ7HX6cYh/wBGTC4SwJeyiCaasOJ4vFlWxN6gUtU0vypEfApLuxpQede+rV4CMJ6MHLgafZXUbHWk76CxFchethcVFvpSG5uEIZkqA1BYN3BtTdoueV6NDqU7tYl/GV4ZSlXRRkyRROYc1MEjgzGrVannSEzsEC9rgF6E1c6WatbxZ8elCUkBAcG7eLvSAuKl0AdnACjrVyb1epbxjl1NNwfJWHkGjBpAoLg3rerNb5UEOCWEAubsw5Owe2os8OzAOOvHVxyd6ioakLGGmrOVBIp2ubMWR3c/PXFbpOiUuyKXdv3mZ7gEMHoKsTraOKRTKASCFD7tXJ1ZxmylWr5uQiYrBFJqCQGIc6itWuSBVrQypLOkJdq0cuCUkDNpe/OjwO06G7BO0sICoEAAJcBIDpIcNRiWcpJalubSEYUnLuoNiX0qzh+TGmpiXlYuyUhiW1dgzs1wD5DlCpjkcbl9WGg4Cqr2NLPFb3SRCVPJEnygHc1ytVmIN+OoPF3qS9Ic6YoJJlgK3wwcuAXXe3E1HIvaCUypGgNWJcboowYUdteMdYjU6cgBZg1OyR+milOuSm0ysJQtgpnmF2zhJAtVz97MfPvq0Z5R9mFKK6vQjWySKVcsRRyzVizTsGVBmCS7KJDvU1Z68K8AYnbN2OHcOrVzYE3ypsnSweOqDWpyjNwvkHbPkzFZczpAL9oue9rkmvKzaxbpmImz5S5K5isiwUqokEpNxmZ2IpHMNgkh3v8ACFK3TaOmEKRXCoru0OjPVIeTmWBUpLZhazAOKWv3wA98VMUMzJQ4pcnUcyaWEaKmbrALbqJaM0+WAJwTWjhQ4KFGPMVNLxbEkBj0cWs5gtnLsRbyMFOj+x5iZpClk7hYAFmdNXURWhpWBErpMvWWk9zj4wd6PdIUqmEdWoHKTccQIlN2W1g//9k=" alt="" class="avatar">
                    </div>
                    <div class="info">

                        <span class="date">{{$item->created_at}}</span>
                        <a href="/posts/{{$item->id}}">
                            <h3 class="title">{{ $item->title }}</h3>
                        </a>
                        <p class="view"><i class="fas fa-eye"></i>{{$item->views}}</i> </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div id="following" class="tab-content" style="display:none;">Nội dung Series</div>
    <div id="follower" class="tab-content" style="display:none;">
        @if(!empty($followers))
            @foreach($followers as $x)
                <h2>{{$x->name}}</h2>
            @endforeach
        @endif
    </div>
</div>

<script>
    function showContent(tabId) {
        // Hide all tab contents
        var contents = document.querySelectorAll('.tab-content');
        contents.forEach(function(content) {
            content.style.display = 'none';
        });

        // Show the selected tab content
        var activeTab = document.getElementById(tabId);
        if (activeTab) {
            activeTab.style.display = 'block';
        }
    }

</script>
@endsection
