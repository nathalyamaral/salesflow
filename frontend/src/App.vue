<template>
  <div id="app">
    <nav>
      <router-link to="/"> 🏠 Home</router-link> |
      <router-link to="/sellers"> 📋 Lista de Vendedores</router-link> |
      <router-link to="/sales/seller"> 📊🧑‍💼 Vendas por Vendedor</router-link> |
      <router-link to="/sellers/create"> ➕ Cadastrar Vendedor</router-link> |
      <router-link to="/sales/create"> ➕ Cadastrar Venda</router-link>
      <router-link to="/run-job"> 📩 Enviar Relatórios</router-link>
    </nav>
    <router-view />
  </div>
</template>

<script>
export default {
  name: "App"
};
</script>

<style>
nav {
  padding: 1rem;
  background: #f4f4f4;
  text-align: center;
}
nav a {
  margin: 0 10px;
  text-decoration: none;
  color: #333;
  font-weight: bold;
}
nav a:hover {
  color: #42b983;
}
</style>
