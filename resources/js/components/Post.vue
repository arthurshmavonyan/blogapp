<template>
    <div class="container">

        <div class="post row">

            <div v-if="post.img !== 'storage/no-image.png'" id="carouselExampleIndicators" class="carousel slide mx-auto my-2" data-ride="carousel">
                <ol class="carousel-indicators" ref="ind">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li v-for="(image, key) in images" v-if="key !== images.length - 1" data-target="#carouselExampleIndicators" :data-slide-to="key + 1"></li>
                </ol>

                <div class="carousel-inner">

                    <div class="carousel-item" v-for="image in images">
                        <img class="img-fluid" :src="image.src" alt="">
                    </div>

                </div>

                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

            <div class="col-md-12 text-center">
                <h1 class="text-primary">{{ post.name }} by {{ user.name }}</h1>

                <p>
                    {{ post.text }}
                </p>
            </div>

        </div>

    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                post: {
                    img: ""
                },
                user: {
                    name: "",
                    id: -1
                },
                images: [],
                currentUser: -1
            }
        },
        props: ['id'],
        mounted() {
            this.update();
        },
        methods: {
            update () {
                axios.get('/api/posts/' + this.id).then((response) => {

                    this.currentUser = response.data['user'];
                    this.post = response.data['post'];
                    this.user.name = response.data['username'];
                    this.user.id = response.data['userid'];

                    $.each(response.data['images'], (key, image) => {
                        if(image.id === this.post.main_id) {
                            this.images.unshift(image);
                            return true;
                        }
                        this.images.push(image);
                    });

                    setTimeout(function () {
                        $('.carousel-item').first().addClass('active');
                    }, 500);

                });
            }
        }
    }
</script>

<style scoped>
    .carousel {
        min-width: 200px;
    }
</style>
