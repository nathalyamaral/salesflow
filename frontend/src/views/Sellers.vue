<script setup>
import { ref, onMounted } from "vue";

const sellers = ref([]);

onMounted(async () => {
  const response = await fetch(`${import.meta.env.VITE_API_URL}/sellers`);
  sellers.value = await response.json();
});
</script>

<template>
  <div>
    <h1>Lista de Sellers</h1>
    <ul>
      <li v-for="seller in sellers" :key="seller.id">
        {{ seller.name }}
      </li>
    </ul>
  </div>
</template>
