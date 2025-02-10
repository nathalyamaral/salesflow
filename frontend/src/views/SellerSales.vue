<template>
  <div>
    <h1>Vendas do Vendedor</h1>

    <label for="seller">Selecione um vendedor:</label>
    <select id="seller" v-model="selectedSeller" @change="fetchSales">
      <option v-for="seller in sellers" :key="seller.id" :value="seller.id">
        {{ seller.name }}
      </option>
    </select>

    <label for="date">Filtrar por Data:</label>
    <input type="date" id="date" v-model="selectedDate" @change="fetchSales" />

    <table v-if="sales.length">
      <thead>
      <tr>
        <th>ID</th>
        <th>Valor</th>
        <th>Comissão</th>
        <th>Data</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="sale in sales" :key="sale.id">
        <td>{{ sale.id }}</td>
        <td>R$ {{ sale.amount.toFixed(2) }}</td>
        <td>R$ {{ sale.commission.toFixed(2) }}</td>
        <td>{{ sale.date }}</td>
      </tr>
      </tbody>
    </table>

    <p v-else>Nenhuma venda encontrada.</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      sellers: [],
      selectedSeller: "",
      selectedDate: "",
      sales: [],
    };
  },
  async mounted() {
    await this.fetchSellers();
  },
  methods: {
    async fetchSellers() {
      try {
        const response = await fetch(`${import.meta.env.VITE_API_URL}/sellers`);
        if (!response.ok) throw new Error("Erro ao buscar vendedores.");
        this.sellers = await response.json();
      } catch (error) {
        console.error(error);
      }
    },
    async fetchSales() {
      if (!this.selectedSeller) return;

      this.sales = [];

      let url = `${import.meta.env.VITE_API_URL}/sales/${this.selectedSeller}`;
      if (this.selectedDate) {
        url += `?date=${this.selectedDate}`;
      }

      try {
        const response = await fetch(url);
        if (!response.ok) throw new Error("Erro ao buscar vendas.");

        const data = await response.json();
        this.sales = data.length ? data : [];
      } catch (error) {
        console.error(error);
        this.sales = [];
      }
    },
  },
};
</script>

<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
}
th, td {
  padding: 10px;
  border: 1px solid #ddd;
}
</style>
