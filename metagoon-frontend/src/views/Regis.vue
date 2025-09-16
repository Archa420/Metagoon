<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-900 px-4">
    <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl p-8 space-y-6">
      
      <!-- Heading -->
      <div class="text-center">
        <h1 class="text-3xl font-extrabold text-gray-900">Reģistrācija</h1>
        <p class="mt-2 text-sm text-gray-600">Aizpildi formu, lai izveidotu kontu</p>
      </div>

      <!-- Form -->
      <form class="space-y-5">
        
        <!-- Vārds -->
        <div>
          <label for="firstname" class="block text-sm font-medium text-gray-700">Vārds</label>
          <input 
            id="firstname" 
            type="text" 
            placeholder="Ievadi savu vārdu"
            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
          />
        </div>

        <!-- Uzvārds -->
        <div>
          <label for="lastname" class="block text-sm font-medium text-gray-700">Uzvārds</label>
          <input 
            id="lastname" 
            type="text" 
            placeholder="Ievadi savu uzvārdu"
            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
          />
        </div>

        <!-- Lietotājvārds -->
        <div>
          <label for="username" class="block text-sm font-medium text-gray-700">Lietotājvārds</label>
          <input 
            id="username" 
            type="text" 
            placeholder="Izvēlies lietotājvārdu"
            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
          />
        </div>

        <!-- Parole -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Parole</label>
          <input 
            id="password" 
            type="password" 
            placeholder="Izvēlies paroli"
            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
          />
        </div>

        <!-- Dzimums -->
        <div>
          <span class="block text-sm font-medium text-gray-700">Dzimums</span>
          <div class="mt-2 flex items-center space-x-6">
            <label class="flex items-center text-sm text-gray-700">
              <input type="radio" name="gender" value="vīrietis" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" />
              <span class="ml-2">Vīrietis</span>
            </label>
            <label class="flex items-center text-sm text-gray-700">
              <input type="radio" name="gender" value="sieviete" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" />
              <span class="ml-2">Sieviete</span>
            </label>
            <label class="flex items-center text-sm text-gray-700">
              <input type="radio" name="gender" value="cits" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" />
              <span class="ml-2">Cits</span>
            </label>
          </div>
        </div>

        <!-- Vecums -->
        <div>
          <label for="age" class="block text-sm font-medium text-gray-700">Vecums</label>
          <input 
            id="age" 
            type="number" 
            placeholder="Ievadi savu vecumu"
            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
          />
        </div>

        <!-- Izvēlne -->
        <div>
          <label for="role" class="block text-sm font-medium text-gray-700">Statuss</label>
          <select 
            id="role"
            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 bg-white text-gray-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
          >
            <option value="">Izvēlies statusu</option>
            <option value="bezdarbnieks">Bezdarbnieks</option>
            <option value="darbinieks">Darbinieks</option>
            <option value="uzņēmējs">Uzņēmējs</option>
          </select>
        </div>

        <!-- Buttons -->
        <div class="space-y-3 pt-2">
          <button 
            type="submit"
            class="w-full rounded-lg bg-indigo-600 px-4 py-2 text-white font-semibold shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
          >
            Reģistrēties
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
