<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-tools text-center">
                            <button class="btn btn-outline-success btn-lg" data-toggle="modal" data-target="#deposito"
                                    @click="openModalWindow(false)">Depósito <i class="fas fa-user-plus fa-fw"></i></button>

                            <button class="btn btn-outline-danger btn-lg" data-toggle="modal" data-target="#deposito"
                                    @click="openModalWindow(true)"> Saque<i class="fas fa-user-plus fa-fw"></i></button>
                        </div>
                    </div>
                    <div class="card-header">
                        <h5 class="card-title">Agência: <strong>{{ user.agencia }}</strong></h5>
                        <h5 class="card-title">Conta-Corrente: <strong>{{ user.conta_corrente }}</strong></h5>
                        <h5 class="card-title">Titular da Conta: <strong>{{ user.name }}</strong></h5>
                        <h5 class="card-title">Saldo Atual: <strong>R$ {{ user.saldo | formatPrice }}</strong></h5>          
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Data</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Valor</th>
                            </tr>

                            <tr v-for="trans in transacoes" :key="trans.id">
                                <td>{{ trans.id }}</td>
                                <td>{{ trans.created_at | formatDate}}</td>
                                <td class="text-center">{{ trans.tipo | strToUpper}}</td>
                                <td class="text-right saque" v-if="trans.tipo == 'saque'">-{{ trans.valor | formatPrice }}</td>
                                <td class="text-left deposito" v-else>{{ trans.valor | formatPrice }}</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="deposito" tabindex="-1" role="dialog" aria-labelledby="depositoLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 v-show="modoSaque" class="modal-title" id="retiradaLabel">Sacar Dinheiro</h5>
                        <h5 v-show="!modoSaque" class="modal-title" id="depositoLabel">Depositar Dinheiro</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="modoSaque ? sacarValor() : depositarValor()">
                        <div class="modal-body">
                            <div class="form-group">
                                <currency-input v-model="form.valor" name="valor" @focus.native="$event.target.select()"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" />
                                <has-error :form="form" field="valor"></has-error>
                            </div>


                            <input type="hidden" v-model="form.tipo" name="tipo">
                            <input type="hidden" v-model="form.user_id" name="user_id">


                        </div>
                        <div class="modal-footer">
                            <button v-show="modoSaque" type="submit" class="btn btn-danger">Sacar</button>
                            <button v-show="!modoSaque" type="submit" class="btn btn-success">Depositar</button>
                            <button type="button"  @click="clearForm()" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['idUser'],
        data() {
            return {
                user: {},
                modoSaque: false,
                transacoes: {},
                form: new Form({
                    user_id: '',
                    valor: 0,
                    tipo: '',

                })
            }
        },
        methods: {

            loadTransactions() {

                let th = this;
                axios.get("api/transacoes/get/" + this.idUser).then(data => (this.transacoes = data.data));
                axios.get("api/user/" + this.idUser).then( function(data) {
                    th.user = data.data;
                });

            },

            openModalWindow(saque = true) {
                this.modoSaque = saque
                this.form.reset();
                this.form.tipo = (saque === true ? 'saque' : 'deposito');
                this.form.user_id = this.user.id;
                $('#deposito').modal('show');
            },

            clearForm() {
                this.form.clear();
                this.form.reset();
                this.form.user_id = this.user.id;
            },


            depositarValor() {

                this.$Progress.start()

                this.form.post('api/transacoes/depositar')
                    .then((data) => {

                        Fire.$emit('CarregarTransacoes');

                        Swal.fire(
                            'Depósito!',
                            'Depósito efetuado com Sucesso',
                            'success'
                        )

                        this.$Progress.finish();
                        $('#deposito').modal('hide');

                    })
                    .catch((err) => {
                        console.log("Error......", err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error...',
                            text: 'Houve um erro no depósito!',
                            // footer: ''
                        });
                    })

            },
            sacarValor() {

                this.form.post('api/transacoes/sacar/')
                    .then(() => {

                         Toast.fire({
                             icon: 'success',
                             title: 'Transação Solicitada!'
                         });
                      

                        Fire.$emit('CarregarTransacoes');

                        $('#deposito').modal('hide');
                    })
                    .catch(() => {
                        console.log("Error......", err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error...',
                            text: 'Houve um erro ao realizar o saque!',
                            // footer: ''
                        });
                    })
            },
        },

        created() {
            this.loadTransactions();

            Fire.$on('CarregarTransacoes', () => { //custom events fire on
                this.loadTransactions();
            });

        }
    }
</script>

<style scoped>

    .saque {
        color: #ff0600;
    }
    .deposito {
        color: #1b873b;
    }
</style>
