<template>
  <div>
    <h1>Cadastrar Vendedor</h1>
    <form @submit.prevent="createSeller">
      <label for="name">Nome:</label>
      <input type="text" id="name" v-model="seller.name" required />

      <label for="email">E-mail:</label>
      <input type="email" id="email" v-model="seller.email" required />

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
      seller: {
        name: "",
        email: ""
      },
      message: "",
      isSuccess: false
    };
  },
  methods: {
    async createSeller() {
      try {
        const response = await fetch(`${import.meta.env.VITE_API_URL}/sellers`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(this.seller)
        });

        if (!response.ok) throw new Error("Erro ao cadastrar vendedor.");

        this.message = "Vendedor cadastrado com sucesso!";
        this.isSuccess = true;
        this.seller.name = "";
        this.seller.email = "";
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
