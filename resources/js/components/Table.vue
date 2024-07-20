<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="t, key in titulos" :key="key">{{ t.titulo }}</th>
                    <th v-if="visualizar.visivel || atualizar.visivel || remover.visivel"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                    <td v-for="valor, chaveValor in obj" :key="chaveValor">
                        <span v-if="titulos[chaveValor].tipo == 'texto'">{{ valor }}</span>
                        <span v-if="titulos[chaveValor].tipo == 'data'">{{ formataDataTempo(valor) }}</span>
                        <span v-if="titulos[chaveValor].tipo == 'imagem'">
                            <img :src="'storage/' + valor" width="55" height="55"/>
                        </span>
                    </td>
                    <td  v-if="visualizar.visivel || atualizar.visivel || remover.visivel">
                       <button v-if="visualizar.visivel" class="btn btn-outline-primary btn-sm me-2" :data-bs-toggle="visualizar.dataBsToggle" :data-bs-target="visualizar.dataBsTarget" @click="setStore(obj)">Visualizar</button>
                       <button v-if="atualizar.visivel" class="btn btn-outline-primary btn-sm me-2" :data-bs-toggle="atualizar.dataBsToggle" :data-bs-target="atualizar.dataBsTarget" @click="setStore(obj)">Atualizar</button>
                       <button v-if="remover.visivel" class="btn btn-outline-danger btn-sm me-2" :data-bs-toggle="remover.dataBsToggle" :data-bs-target="remover.dataBsTarget" @click="setStore(obj)">Remover</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['dados', 'titulos', 'atualizar', 'visualizar', 'remover'],

        methods: {
            setStore(obj) {
                this.$store.state.transacao.status = ''
                this.$store.state.transacao.mensagem = ''
                this.$store.state.transacao.dados = ''
                this.$store.state.item = obj
            },


            // TODO: tornar o método global
            formataDataTempo(d) {
                if(!d) {
                    return ''
                }

                d = d.split('T')

                let data = d[0]
                let tempo = d[1]

                // Formatando a data
                data = data.split('-')
                data = data[2] + '/' + data[1] + '/' +  data[0]

                // Formatando o tempo
                tempo = tempo.split('.')
                tempo = tempo[0]

                return data + ' ' + tempo
            }
        },

        computed: {
            dadosFiltrados() {

                const campos = Object.keys(this.titulos)

                const dadosFiltrados = []

                this.dados.map((item, chave) => {

                    let itemFiltrado = {}

                    campos.forEach(campo => {
                        itemFiltrado[campo] = item[campo]
                    })

                    dadosFiltrados.push(itemFiltrado)

                })

                return dadosFiltrados
            }
        }
    }
</script>
