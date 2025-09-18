<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-900 px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 space-y-6">
      
      <!-- Heading -->
      <div class="text-center">
        <h1 class="text-3xl font-extrabold text-gray-900">Pieslēgties</h1>
        
      </div>

      <!-- Form -->
      <form class="space-y-5" @submit.prevent="login">
        
        <!-- Username -->
        <div>
          <label for="username" class="block text-sm font-medium text-gray-700">Lietotājvārds</label>
          <input 
            id="username" 
            type="text" 
            placeholder="Ievadi lietotājvārdu"
            v-model="username"
            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
          />

        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Parole</label>
          <input 
            id="password" 
            type="password" 
            placeholder="Ievadi paroli"
            v-model="password"
            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
          />
        </div>

        <!-- Remember me + Forgot password -->
        <div class="flex items-center justify-between">
          <label class="flex items-center text-sm text-gray-600">
            <input type="checkbox" class="h-4 w-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500" />
            <span class="ml-2">Atcerēties mani</span>
          </label>
          <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Aizmirsi paroli?</a>
        </div>

        <!-- Buttons -->
        <div class="space-y-3">
          <button 
          type="submit"
          class="w-full rounded-lg bg-indigo-600 px-4 py-2 text-white font-semibold shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
        >
          Pieslēgties
        </button>

          <button 
            type="button"
            class="w-full rounded-lg bg-gray-100 px-4 py-2 text-gray-700 font-semibold hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2"
          >
            Atcelt
          </button>
        </div>

      </form>
    </div>
  </div>
</template>
<script setup lang="ts">
import { ref } from "vue";
import api from "../services/api.js"; // your Axios instance

const username = ref("");
const password = ref("");

const login = async () => {
  try {
    const response = await api.post("/login", {
      username: username.value,
      password: password.value,
    });

    localStorage.setItem("token", response.data.token);
    window.location.href = "/profile"; // redirect after login
  } catch (err: any) {
    console.error(err.response?.data || err);
    alert("Nepareizs lietotājvārds vai parole"); // simple feedback
  }
};
</script>
