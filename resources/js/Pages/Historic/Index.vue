<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';

const startDate = ref('');
const endDate = ref('');
const transactionType = ref('');
const userName = ref('');
const currentPage = ref(1);

const transactionTypes = [
    { label: 'Todas', value: '' },
    { label: 'Entrada', value: 'I' },
    { label: 'Saque', value: 'O' },
    { label: 'Transferência', value: 'T' }
];

const applyFilter = () => {
    router.get(route('historic.index'), {
        start_date: startDate.value,
        end_date: endDate.value,
        transaction_type: transactionType.value,
        user_name: userName.value,
        page: currentPage.value,
    }, {
        preserveState: true
    });
};

const clearFilter = () => {
    startDate.value = '';
    endDate.value = '';
    transactionType.value = '';
    userName.value = '';
    currentPage.value = 1;
    
    applyFilter();
};

const page = usePage();
const historic = computed(() => {
    return page.props.historic || { data: [], current_page: 1, last_page: 1 };
});

const formatCurrency = (value) => {
    if (!value) return 'R$ 0,00';

    const numericValue = parseFloat(String(value).replace(/[^\d.-]/g, ''));
    
    if (isNaN(numericValue)) {
        return 'R$ 0,00';
    }
    
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(numericValue);
};

const goToPreviousPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
        applyFilter();
    }
};

const goToNextPage = () => {
    if (currentPage.value < historic.value.last_page) {
        currentPage.value++;
        applyFilter();
    }
};

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('pt-BR').format(date);
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

                    <div class="mt-4 flex justify-end space-x-2">
                        <button @click="applyFilter" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">
                            Filtrar
                        </button>
                        <button @click="clearFilter" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition duration-200">
                            Limpar Filtro
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
                                <th class="px-4 py-2 border-b text-left">Transferência</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="transaction in historic.data" :key="transaction.id">
                                <td class="px-4 py-2 border-b">{{ transaction.id }}</td>
                                <td class="px-4 py-2 border-b">{{ transaction.type }}</td>
                                <td class="px-4 py-2 border-b">{{ formatCurrency(transaction.amount) }}</td>
                                <td class="px-4 py-2 border-b">{{ formatCurrency(transaction.total_before) }}</td>
                                <td class="px-4 py-2 border-b">{{ formatCurrency(transaction.total_after) }}</td>
                                <td class="px-4 py-2 border-b">{{ formatDate(transaction.date) }}</td>
                                <td class="px-4 py-2 border-b">{{ transaction.user.name }}</td>
                                <td class="px-4 py-2 border-b">
                                    {{ transaction.transaction_user ? transaction.transaction_user.name : 'N/A' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-4 flex justify-between items-center">
                        <button @click="goToPreviousPage" :disabled="currentPage === 1" class="bg-gray-300 text-gray-600 px-4 py-2 rounded hover:bg-gray-400 disabled:opacity-50">
                            Anterior
                        </button>
                        <span>Página {{ historic.current_page }} de {{ historic.last_page }}</span>
                        <button @click="goToNextPage" :disabled="currentPage === historic.last_page" class="bg-gray-300 text-gray-600 px-4 py-2 rounded hover:bg-gray-400">
                            Próxima
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
