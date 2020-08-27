<template>
    <div>
        <div class="container my-4 d-flex flex-row">
            <h1 class="h3 mr-auto">Gourmet Game</h1>
        </div>

        <div class="container col-12 col-sm-6 col-md-4 col-lg-3 justify-content-center">
            <div class="card">
                <div class="card-header">Pense em um prato</div>

                <div class="card-body">
                    <button v-on:click="startGame()" class="btn btn-success ml-2" type="button">Iniciar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                polls: [],
                newPoll: [],
                newFormPoll: false
            }
        },
        methods: {
            startGame() {
                axios.get('/api/v1/game').then(response => {
                    this.question = response.question;
                });
            },
            showFormPoll() {
                if(!this.newFormPoll) {
                    this.newFormPoll = true
                }
            },
            hideFormPoll() {
                if(this.newFormPoll) {
                    this.newFormPoll = false
                }
            }
        }
    }
</script>
