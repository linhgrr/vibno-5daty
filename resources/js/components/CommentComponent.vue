<template>
    <div>
        <ul class="comment-list">
            <li v-for="comment in comments" :key="comment.id" class="comment">
                <div class="comment-meta">
                    <span class="comment-author">{{ comment.name }}</span>
                    <span class="comment-date">{{ comment.created_at }}</span>
                </div>
                <p class="comment-content">{{ comment.content }}</p>
            </li>
        </ul>
        <form v-if="isAuthenticated" class="comment-form" @submit.prevent="postComment">
            <h4>Add a Comment</h4>
            <label for="comment-content">Comment:</label>
            <textarea id="comment-content" v-model="commentContent" rows="4" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </div>
</template>

<script>
export default {
    props: ['userId','postId', 'initialComments', 'isAuthenticated'],
    data() {
        return {
            comments: this.initialComments,
            commentContent: ''
        }
    },
    methods: {
        postComment() {
            axios.post('/comments', {
                content: this.commentContent,
                post_id: this.postId,
            })
                .then(response => {
                    this.comments.push(response.data);
                    this.commentContent = '';
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }
}
</script>
