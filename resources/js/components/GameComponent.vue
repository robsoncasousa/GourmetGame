<template>
    <div>
        <div class="container my-4 d-flex flex-row">
            <h1 class="h3 mr-auto">Gourmet Game</h1>
        </div>

        <div class="container col-12 col-sm-12 col-md-6 col-lg-5 justify-content-center">
            <div  class="card">
                <div class="card-header">{{ message }}</div>

                <div v-if="gameResult == '' && finished == ''" class="card-body">
                    <div v-if="typeId == '' && dishId == ''" class="d-flex flex-row justify-content-center">
                        <button v-on:click="startGame()" class="btn btn-success ml-2" type="button">Iniciar</button>
                    </div>

                    <div v-else class="d-flex flex-row justify-content-center">
                        <button v-on:click="sendAnswer('yes')" class="btn btn-success ml-2" type="button">Sim</button>
                        <button v-on:click="sendAnswer('no')" class="btn btn-primary ml-2" type="button">Não</button>
                    </div>
                </div>

                <div v-if="gameResult == 'win'" class="card-body">
                    <div>Acertei de Novo!</div>
                    <div>{{ dishName }} foi jogado {{ qtyPlayed }} {{ (qtyPlayed > 1) ? "vezes" : "vez" }}!</div>
                    <button v-on:click="restart()" class="btn btn-primary ml-2 mt-3" type="button">Reiniciar</button>

                </div>
                <div v-if="gameResult == 'lose'" class="card-body">
                    <div>Desisto!</div>
                    <div class="form-group">
                        <label for="newdish">Qual prato você pensou?</label>
                        <input type="text" class="form-control" id="newdish" v-model="newDish">
                    </div>
                    <div v-if="newDish != ''" class="form-group">
                        <label for="newType">{{ newDish }} é _________________ mas {{ dishName }} não.</label>
                        <input type="text" class="form-control" id="newType" v-model="difference">
                    </div>
                    <button v-on:click="saveNewDish()" class="btn btn-primary ml-2" type="button">Enviar</button>
                </div>

                <div v-if="finished == 'yes'" class="card-body">
                    <div>Obrigado por contribuir!</div>
                    <button v-on:click="restart()" class="btn btn-primary ml-2" type="button">Reiniciar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                message: 'Pense em um prato!',
                typeId: '',
                dishId: '',
                dishName: '',
                gameResult: '',
                qtyPlayed: '',
                newDish: '',
                difference: '',
                finished: ''
            }
        },
        methods: {
            restart() {
                this.message = 'Pense em um prato!';
                this.typeId = '';
                this.dishId = '';
                this.dishName = '';
                this.gameResult = '';
                this.qtyPlayed = '';
                this.newDish = '';
                this.difference = '';
                this.finished = '';
            },
            startGame() {
                axios.get('/api/v1/game').then(response => {
                    this.message = response.data.message;
                    this.typeId = response.data.typeId;
                });
            },
            sendAnswer($answer) {
                axios.post('/api/v1/game', {
                    'type_id': this.typeId,
                    'dish_id': this.dishId,
                    'answer': $answer,
                }).then(response => {
                    if(response.data.gameResult) {
                        this.gameResult = response.data.gameResult;
                        this.dishName = response.data.dishName;
                        this.qtyPlayed = response.data.qtyPlayed;
                        if(response.data.gameResult == 'win') {
                            this.message = 'Ebaaa \\o/';
                        }
                        else {
                            this.message = 'Você venceu!';
                        }
                    } else {
                        this.message = response.data.message;
                        this.typeId = response.data.typeId;
                        this.dishId = response.data.dishId;
                    }
                });
            },
            saveNewDish() {
                axios.post('/api/v1/game/newdish', {
                    'new_dish': this.newDish,
                    'difference': this.difference,
                }).then(response => {
                    this.gameResult = '';
                    this.finished = response.data.finished;
                });
            }
        }
    }
</script>
