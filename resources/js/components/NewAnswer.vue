<template>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>Your answer</h2>
                </div>
`
                <hr>

                <form @submit.prevent="create">

                    <div class="form-group">
                        <textarea v-model="body" class="form-control" required rows="7" name="body">


                        </textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" :disabled="isInvalid" class="btn btn-lg btn-outline-primary">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</template>


<script>
    export default {

        props : ['questionId'],


        data(){
            return {
                body : ''
            }
        },

        computed : {

            isInvalid(){

                return !this.signedIn || this.body.length < 10;

            }
        },

        methods : {
             create(){
                  axios.post(`/questions/${this.questionId}/answers`,{
                      body : this.body
                      })
                      .then(({data}) =>{

                          this.$toast.success(data.message,'Success');
                          this.body ="";

                          this.$emit('created',data.answer);


                      })
                      .catch(error =>{
                          this.$toast.error(error.responce.data.message)
                      })


            }


        }

    }

    </script>