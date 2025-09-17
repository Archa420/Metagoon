<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api";

const user = ref(null);

onMounted(async () => {
  try {
    const response = await api.get("/profile");
    user.value = response.data;
  } catch (err) {
    console.error(err);
  }
});
</script>

<template>
  <div class="max-w-xl mx-auto bg-white rounded-2xl shadow p-6 mt-10">
    <h2 class="text-2xl font-bold">Mans profils</h2>
    <div v-if="user" class="mt-4 space-y-2">
      <p><strong>Vārds:</strong> {{ user.name }}</p>
      <p><strong>Lietotājvārds:</strong> {{ user.username }}</p>
      <p><strong>Statuss:</strong> {{ user.role }}</p>
      <p v-if="user.role === 'uzņēmējs'">
        <strong>Uzņēmuma reģ. nr:</strong> {{ user.company_number }} <br>
        <strong>Juridiskā adrese:</strong> {{ user.company_address }}
      </p>
    </div>
  </div>
</template>
