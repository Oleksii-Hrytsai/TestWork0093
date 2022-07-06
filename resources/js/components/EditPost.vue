<template>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Update Post Data</h5>
                <div>
                    <router-link :to="{name: 'posts'}" class="btn btn-success">Go Back</router-link>
                </div>
            </div>

            <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{strSuccess}}</strong>
            </div>

            <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{strError}}</strong>
            </div>


            <form @submit.prevent="updatePost" enctype="multipart/form-data">
                <div class="form-group mb-2">
                    <label>Name</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control" v-model="name" placeholder="Enter post name">
                </div>

                <div class="form-group mb-2">
                    <label>Description</label><span class="text-danger"> *</span>
                   <textarea class="form-control" rows="3" v-model="description" placeholder="Enter post description"></textarea>
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4"> Update Post</button>

            </form>

        </div>
    </div>
</template>

<script>
export default{
    data() {
        return {
            id:'',
            name: '',
            description: '',
            strSuccess: '',
            strError: '',
            imgPreview: null
        }
    },

    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/posts/edit/${this.$route.params.id}`)
            .then(response => {
                this.name = response.data['name'];
                this.description = response.data['description'];
            })
            .catch(function(error) {
                console.log(error);
            });
        })
    },
    methods: {
        updatePost(e) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                let existingObj = this;
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }

                const formData = new FormData();
                formData.append('name', this.name);
                formData.append('description', this.description);

                this.$axios.post(`/api/posts/update/${this.$route.params.id}`, formData, config)
                .then(response => {
                    existingObj.strError = "";
                    existingObj.strSuccess = response.data.success;
                })
                .catch(function(error) {
                    existingObj.strSuccess ="";
                    existingObj.strError = error.response.data.message;
                });
            });
        }

    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}

</script>
