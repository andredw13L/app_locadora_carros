<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="t, key in titulos" :key="key" class="text-uppercase">{{ t }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="obj in dados" :key="obj.id">            
                    <template v-for="(valor, chave) in obj">
                        <td v-if="titulos.includes(chave)" :key="chave">
                            <span v-if="chave == 'imagem'">
                                <img 
                                 :src="'storage/' + valor" 
                                 width="55" 
                                 height="55"
                                />
                            </span>
                            <span v-else> {{ valor }}</span>
                        </td>
                    </template>
                    <!--
                    <th scope="row">{{ m.id }}</th>
                    <td>{{ m.nome }}</td>
                    <td><img :src="'/storage/' + m.imagem" width="55" height="55"></td> 
                    -->
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['dados', 'titulos']
    }
</script>
