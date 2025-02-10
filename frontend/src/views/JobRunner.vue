<template>
  <div>
    <h1>Rodar Job de Envio de Relatório</h1>
    <button @click="runJob">📤 Enviar Relatórios de Vendas</button>
    <button @click="openMailhog">📬 Abrir MailHog</button>
    <p v-if="message" class="message">{{ message }}</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      message: "",
    };
  },
  methods: {
    async runJob() {
      this.message = "⏳ Executando o job...";

      try {
        const response = await fetch(`${import.meta.env.VITE_API_URL}/run-job`, {
          method: "POST",
        });

        if (!response.ok) throw new Error("Erro ao executar o job.");

        this.message = "✅ Job executado com sucesso! E-mails enviados.";
      } catch (error) {
        console.error(error);
        this.message = "❌ Erro ao executar o job.";
      }
    },
    openMailhog() {
      window.open("http://localhost:8025", "_blank");
    },
  },
};
</script>

<style scoped>
button {
  margin: 10px;
  padding: 10px;
  font-size: 16px;
  cursor: pointer;
  border: none;
  border-radius: 5px;
}
button:first-of-type {
  background-color: #42b983;
  color: white;
}
button:last-of-type {
  background-color: #3498db;
  color: white;
}
button:hover {
  opacity: 0.8;
}
.message {
  margin-top: 15px;
  font-weight: bold;
}
</style>
