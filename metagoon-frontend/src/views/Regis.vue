<template>
  <div class="min-h-screen flex items-center justify-center bg-[#0b0c10] text-gray-100 px-6">
    <div
      class="w-full max-w-2xl rounded-3xl border border-indigo-900/30 bg-gradient-to-br from-gray-950 via-gray-900 to-gray-950 p-8 shadow-2xl relative overflow-hidden"
    >
      <!-- Glow overlay -->
      <div
        class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,_var(--tw-gradient-stops))] from-indigo-700/20 via-fuchsia-700/10 to-transparent pointer-events-none"
      ></div>

      <!-- Heading -->
      <div class="relative text-center space-y-2 z-10">
        <h1
          class="text-4xl font-extrabold bg-gradient-to-r from-indigo-400 via-fuchsia-400 to-cyan-400 bg-clip-text text-transparent"
        >
          Reģistrācija
        </h1>
        <p class="text-gray-400 text-sm">
          Aizpildi formu, lai pievienotos MetaGoon platformai
        </p>
      </div>

      <!-- Form -->
      <form class="mt-8 space-y-5 relative z-10" @submit.prevent="register">
        <!-- Name fields -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label for="firstname" class="block text-sm font-medium text-gray-300 mb-1">Vārds</label>
            <input id="firstname" type="text" v-model="firstname" placeholder="Ievadi savu vārdu" class="input-style" />
          </div>

          <div>
            <label for="lastname" class="block text-sm font-medium text-gray-300 mb-1">Uzvārds</label>
            <input id="lastname" type="text" v-model="lastname" placeholder="Ievadi savu uzvārdu" class="input-style" />
          </div>
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-300 mb-1">E-pasts</label>
          <input
            id="email"
            type="email"
            v-model="email"
            placeholder="Ievadi savu e-pastu"
            class="input-style"
          />
        </div>

        <!-- Username -->
        <div>
          <label for="username" class="block text-sm font-medium text-gray-300 mb-1">Lietotājvārds</label>
          <input
            id="username"
            type="text"
            v-model="username"
            placeholder="Izvēlies lietotājvārdu"
            class="input-style"
          />
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Parole</label>
          <input
            id="password"
            type="password"
            v-model="password"
            placeholder="Izvēlies paroli"
            class="input-style"
          />
        </div>

        <!-- Gender -->
        <div>
          <span class="block text-sm font-medium text-gray-300">Dzimums</span>
          <div class="mt-2 flex items-center flex-wrap gap-4 text-gray-300 text-sm">
            <label class="flex items-center">
              <input type="radio" value="vīrietis" v-model="gender" class="h-4 w-4 text-indigo-600 border-gray-600 focus:ring-indigo-400" />
              <span class="ml-2">Vīrietis</span>
            </label>
            <label class="flex items-center">
              <input type="radio" value="sieviete" v-model="gender" class="h-4 w-4 text-indigo-600 border-gray-600 focus:ring-indigo-400" />
              <span class="ml-2">Sieviete</span>
            </label>
            <label class="flex items-center">
              <input type="radio" value="cits" v-model="gender" class="h-4 w-4 text-indigo-600 border-gray-600 focus:ring-indigo-400" />
              <span class="ml-2">Cits</span>
            </label>
          </div>
        </div>

        <!-- Birth Date -->
        <div>
          <label for="birth_date" class="block text-sm font-medium text-gray-300 mb-1">Dzimšanas datums</label>
          <input
            id="birth_date"
            type="date"
            v-model="birth_date"
            class="input-style"
          />
        </div>

        <!-- Role -->
        <div>
          <label for="role" class="block text-sm font-medium text-gray-300 mb-1">Statuss</label>
          <select id="role" v-model="role" class="input-style bg-gray-800/60 text-gray-100">
            <option value="">Izvēlies statusu</option>
            <option value="bezdarbnieks">Bezdarbnieks</option>
            <option value="uzņēmējs">Uzņēmējs</option>
          </select>
        </div>

        <!-- Entrepreneur fields -->
        <div v-if="role === 'uzņēmējs'" class="pt-4 space-y-3 border-t border-gray-700">
          <h3 class="text-sm font-semibold text-indigo-400">Uzņēmuma informācija</h3>

          <div>
            <label for="company_name" class="block text-sm font-medium text-gray-300 mb-1">Nosaukums</label>
            <input id="company_name" type="text" placeholder="Ievadi uzņēmuma nosaukumu" v-model="company_name" class="input-style" />
          </div>

          <div>
            <label for="company_number" class="block text-sm font-medium text-gray-300 mb-1">Reģistrācijas numurs</label>
            <input id="company_number" type="text" placeholder="Ievadi uzņēmuma reģ. numuru" v-model="company_number" class="input-style" />
          </div>

          <div>
            <label for="company_address" class="block text-sm font-medium text-gray-300 mb-1">Juridiskā adrese</label>
            <input id="company_address" type="text" placeholder="Ievadi juridisko adresi" v-model="company_address" class="input-style" />
          </div>
        </div>

        <!-- Buttons -->
        <div class="pt-4 space-y-3">
          <button
            type="submit"
            class="w-full rounded-xl bg-gradient-to-r from-indigo-600 via-fuchsia-500 to-cyan-500 py-2.5 text-white font-semibold shadow-lg hover:opacity-90 active:scale-[.98] transition"
          >
            Reģistrēties
          </button>

          <RouterLink
            to="/login"
            class="block w-full text-center rounded-xl border border-gray-700 bg-gray-800/60 py-2.5 text-gray-200 font-semibold hover:bg-gray-800 transition"
          >
            Atpakaļ uz pieslēgšanos
          </RouterLink>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { RouterLink } from "vue-router";
import api from "../services/api.js";

const firstname = ref("");
const lastname = ref("");
const email = ref("");
const username = ref("");
const password = ref("");
const gender = ref("");
const birth_date = ref("");
const role = ref("");
const company_number = ref("");
const company_address = ref("");
const company_name = ref("");

const register = async () => {
  try {
    const response = await api.post("/register", {
      firstname: firstname.value,
      lastname: lastname.value,
      email: email.value,
      username: username.value,
      password: password.value,
      gender: gender.value,
      birth_date: birth_date.value,
      role: role.value,
      company_name: role.value === "uzņēmējs" ? company_name.value : null,
      company_number: role.value === "uzņēmējs" ? company_number.value : null,
      company_address: role.value === "uzņēmējs" ? company_address.value : null,
    });

    localStorage.setItem("token", response.data.token);
    localStorage.setItem("role", response.data.user.role);
    window.location.href = "/profile";
  } catch (err: any) {
    console.error(err.response?.data || err);
    alert(err.response?.data?.message || "Neizdevās reģistrēties");
  }
};
</script>

<style scoped>
.input-style {
  width: 100%;
  padding: 0.5rem 0.75rem;
  border-radius: 0.75rem;
  border: 1px solid rgb(55 65 81);
  background-color: rgba(31, 41, 55, 0.6);
  color: #f3f4f6;
  font-size: 0.875rem;
}
.input-style:focus {
  outline: none;
  border-color: rgb(99, 102, 241);
  box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.4);
}
</style>
