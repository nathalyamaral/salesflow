<template>
  <div>
    <h1>Cadastrar Venda</h1>

    <form @submit.prevent="createSale">
      <label for="seller">Vendedor:</label>
      <select id="seller" v-model="sale.sellerId" required>
        <option v-for="seller in sellers" :key="seller.id" :value="seller.id">
          {{ seller.name }}
        </option>
      </select>

      <label for="amount">Valor da Venda:</label>
      <input type="number" id="amount" v-model="sale.amount" required />

      <button type="submit">Cadastrar</button>
    </form>

    <p v-if="message" :class="{ success: isSuccess, error: !isSuccess }">
      {{ message }}
    </p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      sale: {
        sellerId: "",
        amount: ""
      },
      sellers: [],
      message: "",
      isSuccess: false
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
    async createSale() {
      try {
        const response = await fetch(`${import.meta.env.VITE_API_URL}/sales`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(this.sale)
        });

        if (!response.ok) throw new Error("Erro ao cadastrar venda.");

        this.message = "Venda cadastrada com sucesso!";
        this.isSuccess = true;
        this.sale.sellerId = "";
        this.sale.amount = "";
      } catch (error) {
        this.message = error.message;
        this.isSuccess = false;
      }
    }
  }
};
</script>

<style scoped>
.success {
  color: green;
}
.error {
  color: red;
}
</style>
