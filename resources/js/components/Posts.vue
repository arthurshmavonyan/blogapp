<template>
    <div class="container">

        <router-link to="/create/post" class="btn btn-primary">Create post</router-link>

        <div v-for="post in collection" class="post row rounded m-3 p-2">
                <div class="col-md-3">
                    <img class="img-fluid mx-auto" v-bind:src="post.src ? post.src : '/img/no-image.png'">
                </div>
                <div class="body col-md-9">

                    <h2 class="text-info">{{ post.name }}</h2>

                    <p class="post-text">{{ text(post.text) }}...</p>

                    <span>
                        <button class="btn btn-danger btn-xs mx-1" v-if="post.user_id == user_id" @click.prevent="deletePost(post)">Delete post</button>
                        <router-link v-bind:to="'/edit/post/' + post.id" v-if="post.user_id == user_id" class="btn btn-xs btn-primary mx-1">Edit post</router-link>
                        <router-link v-bind:to="'/post/' + post.id" class="btn btn-xs btn-primary mx-2">Open post</router-link>
                        Created at: {{ post.created_at }}
                    </span>

                </div>

        </div>

        <div class="btn-group" role="group">
            <button type="button" class="btn btn-primary" v-for="p in pagination.pages" @click.prevent="setPage(p)">{{ p }}</button>
        </div>
        <p v-if="posts.length">Displaying posts from {{ startIndexV }} to {{ endIndexV }}</p>
        <h4 v-else style="margin-top: 1rem">No posts</h4>

    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                posts: [],
                perPage: 10,
                pagination: {},
                user_id: -1
            }
        },
        mounted () {

            axios.get('/api/posts').then((response) => {
                this.posts = response.data;
                $.each(this.posts, (key, post) => {
                    this.setPage(1);
                });
            });

            axios.get('/api/me').then((response) => {
                this.user_id = response.data['id'];
            });

        },
        computed: {
            collection () {
                return this.paginate(this.posts);
            },
            startIndexV () {
                return this.pagination.startIndex + 1;
            },
            endIndexV () {
                return this.pagination.endIndex + 1;
            }
        },
        methods: {
            setPage(p) {
                this.pagination = this.paginator(this.posts.length, p);
            },

            paginate(data) {
                return _.slice(data, this.pagination.startIndex, this.pagination.endIndex + 1);
            },

            paginator(totalItems, currentPage) {
                let startIndex = (currentPage - 1) * this.perPage;
                let endIndex = Math.min(startIndex + this.perPage - 1, totalItems - 1);

                return {
                    currentPage: currentPage,
                    startIndex: startIndex,
                    endIndex: endIndex,
                    pages: _.range(1, Math.ceil(totalItems / this.perPage) + 1)
                };
            },
            update() {
                axios.get('/api/posts').then((response) => {
                    this.posts = response.data;
                    this.setPage(1);
                });
            },
            text (text) {
                return text.substring(0, 150);
            },
            deletePost(post) {
                axios.delete('/api/posts/' + post.id).then((response) => {
                    this.update();
                });
            }
        }
    }
</script>

<style scoped>

    .post {
        background: #eee;
    }

    img {
        display: block;
    }

    .body {
        position: relative;
    }

    .body .post-text {
        margin-bottom: 7rem;
    }

    .body span {
        position: absolute;
        bottom: 0;
        right: 1rem;
    }
</style>
