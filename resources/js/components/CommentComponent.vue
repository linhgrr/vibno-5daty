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
        <form v-if="authenticated" @submit.prevent="addComment" class="comment-form">
            <h4>Add a Comment</h4>
            <label for="comment-content">Comment:</label>
            <textarea v-model="newComment" id="comment-content" rows="4" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </div>
</template>

<script>
export default {
    props: {
        initialComments: Array,
        authenticated: Boolean,
        postId: Number
    },
    data() {
        return {
            comments: this.initialComments,
            newComment: '',
        }
    },
    methods: {
        addComment() {
            axios.post('/comments', {
                content: this.newComment,
                post_id: this.postId,
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            })
                .then(response => {
                    this.comments.push(response.data);
                    this.newComment = ''; // Clear input after submission
                })
                .catch(error => {
                    console.error('Error adding comment:', error);
                });
        }
    }
}
</script>
