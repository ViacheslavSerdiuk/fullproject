<template>
    <div>
    <div class="row mt-4" v-cloak v-if="count">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{title}}</h2>
                    </div>

                    <hr>
                         <answer v-on:deleted="remove(index)"  v-for="(answer,index) in answers" :answer="answer" :key="answer.id"></answer>
                    <div class="text-center mt-3" v-if="nextUrl">
                        <button @click.prevent="fetch(nextUrl)" class="btn btn-outline-secondary">Load more</button>



                    </div>
                </div>
            </div>
        </div>
    </div>
     <new-answer @created ="add" :questionId="questionId" ></new-answer>
    </div>
</template>

<script>
    import Answer from './Answer';
    import NewAnswer from './NewAnswer';

    export default {

        props :['question'],

        data : function(){
          return{
              questionId : this.question.id,
              count : this.question.answers_count,
              answers : [],
              nextUrl : null
          }
        },

        created (){
            console.log(this.nextUrl);
           this.fetch(`/questions/${this.questionId}/answers`);


        },

        methods : {

            add(answer){
                this.answers.push(answer);
                this.count++;

            },
            remove(index){
                this.answers.splice(index,1);
                this.count--;
            },

            fetch(endpoint){
                axios.get(endpoint)
                    .then(({data})=>{

                        this.answers.push(...data.data);
                        this.nextUrl = data.next_page_url.replace(/^http:\/\//i, 'https://');

                    })


            },



        },

        computed :{

            title(){
                return this.count + " " + (this.count > 0 ? 'Answers' : 'Answer');
            },




        },

        components : {Answer , NewAnswer}

    }


</script>