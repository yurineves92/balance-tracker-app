<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const startDate = ref('');
const endDate = ref('');
const transactionType = ref('');
const userName = ref('');
const currentPage = ref(1);
const transactionsPerPage = 10;

const transactionTypes = [
    { label: 'Todas', value: '' },
    { label: 'Entrada', value: 'I' }, // I = Entrada
    { label: 'Saque', value: 'O' }, // O = Saque
    { label: 'Transferência', value: 'T' } // T = Transferência
];

const applyFilter = () => {
    console.log('Filtrando por:', {
        startDate: startDate.value,
        endDate: endDate.value,
        transactionType: transactionType.value,
        userName: userName.value
    });
};

const exportToXLS = () => {
    console.log('Exportando para XLS...');
};

const exportToPDF = () => {
    console.log('Exportando para PDF...');
};
</script>

<template>
    <Head title="Histórico de Transações" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Histórico de Transações</h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-md sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4">Filtrar Transações</h3>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nome do Usuário</label>
                            <input type="text" v-model="userName" placeholder="Digite o nome" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Data de Início</label>
                            <input type="date" v-model="startDate" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Data de Fim</label>
                            <input type="date" v-model="endDate" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tipo de Transação</label>
                            <select v-model="transactionType" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option v-for="type in transactionTypes" :key="type.value" :value="type.value">{{ type.label }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <button @click="applyFilter" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">
                            Filtrar
                        </button>
                    </div>
                </div>

                <div class="mb-4 flex justify-end space-x-4">
                    <button @click="exportToXLS" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition duration-200">
                        Exportar para XLS
                    </button>
                    <button @click="exportToPDF" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition duration-200">
                        Exportar para PDF
                    </button>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800">Transações</h3>
                    <table class="min-w-full mt-4 bg-white border-collapse">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b text-left">ID</th>
                                <th class="px-4 py-2 border-b text-left">Tipo</th>
                                <th class="px-4 py-2 border-b text-left">Quantia</th>
                                <th class="px-4 py-2 border-b text-left">Antes</th>
                                <th class="px-4 py-2 border-b text-left">Depois</th>
                                <th class="px-4 py-2 border-b text-left">Data</th>
                                <th class="px-4 py-2 border-b text-left">Usuário</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="transaction in 10" :key="transaction">
                                <td class="px-4 py-2 border-b">{{ transaction }}</td>
                                <td class="px-4 py-2 border-b">Entrada</td>
                                <td class="px-4 py-2 border-b text-green-500">+R$ 2.500,00</td>
                                <td class="px-4 py-2 border-b">R$ 30.000,00</td>
                                <td class="px-4 py-2 border-b">R$ 32.500,00</td>
                                <td class="px-4 py-2 border-b">15/10/2024</td>
                                <td class="px-4 py-2 border-b">Yuri</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="mt-4 flex justify-between items-center">
                        <button @click="currentPage--" :disabled="currentPage === 1" class="bg-gray-300 text-gray-600 px-4 py-2 rounded hover:bg-gray-400 disabled:opacity-50">
                            Anterior
                        </button>
                        <span>Página {{ currentPage }}</span>
                        <button @click="currentPage++" class="bg-gray-300 text-gray-600 px-4 py-2 rounded hover:bg-gray-400">
                            Próxima
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
