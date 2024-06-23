<template>
    <div class="user-vote" v-if="authenticated">
        <div class="vote-container">
            <button class="vote-button"  @click="submitVote('upvote')">
                <svg :class="{ 'active': is_voted === 1 }" viewBox="0 0 24 24">
                    <path d="M12 4.5l-7 7h14z"></path>
                </svg>
            </button>
            <div  class="vote-count">{{ vote_count }}</div>
            <button class="vote-button" @click="submitVote('downvote')" :class="{ 'active': is_voted === -1 }">
                <svg  :class="{ 'active': is_voted === -1 }" viewBox="0 0 24 24">
                    <path d="M12 19.5l-7-7h14z"></path>
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props:{
      authenticated: Boolean,
      postId: Number,
      voteCount: Number,
        isVoted: Number
    },
    data() {
        return {
            post_id: this.postId,
            vote_count: this.voteCount,
            is_voted: this.isVoted
        };
    },
    methods: {
        async submitVote(type) {
            try {
                if (this.is_voted === 1 && type === 'upvote') {
                    type = 'unvote';
                } else if (this.is_voted === -1 && type === 'downvote') {
                    type = 'unvote';
                }

                const response = await axios.post(`/votes/${type}`, {
                    post_id: this.post_id,
                    is_voted: this.is_voted,
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                });
                this.is_voted = response.data.isVoted
                this.vote_count = response.data.voteCount;
            } catch (error) {
                console.error('Error submitting vote:', error);
            }
        }
    },
    mounted() {
        // Initialize data here
    }
}
</script>

<style scoped>
.user-vote{
    margin-right: 40px;
    position: sticky;
    top: 0;
    height: 100dvh;
}

.vote-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    font-family: Arial, sans-serif;
}
.vote-button {
    border: none;
    background: none;
    cursor: pointer;
    padding: 10px; /* Thêm padding để tăng kích thước vùng bấm */
}
.vote-button:focus {
    outline: none;
}
.vote-button svg {
    width: 48px; /* Tăng kích thước SVG */
    height: 48px; /* Tăng kích thước SVG */
    fill: gray;
}
.vote-count {
    font-size: 24px;
    color: gray;
    margin: -20px 0;
}

.active{
    fill: #4158D0 !important;
}
</style>
