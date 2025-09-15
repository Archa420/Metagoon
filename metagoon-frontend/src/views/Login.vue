<template>

    <div class="mx-auto flex min-h-screen w-full items-center justify-center bg-gray-900">
        
        <div class="login container justify-center flex	max-w-screen bg-white flex-1">
            <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
                <div class="mt-12 flex flex-col items-center">
                
                <h1 class="text-2xl xl:text-3xl font-extrabold">Pieslēdzies!</h1>
                <div class="w-full border-none transform border-b-2 bg-transparent text-lg duration-300 focus-within:border-indigo-500">
                    <label for="Username"><b>Lietotājvārds</b></label>
                    <input type="text" placeholder="Ievadi lietotājvārdu" name="Username" class="w-full border-none bg-transparent outline-none placeholder:italic focus:outline-none" >
                </div>
                <div class="w-full border-none transform border-b-2 bg-transparent text-lg duration-300 focus-within:border-indigo-500" >
                    <label for="Password"><b>Parole</b></label>
                    <input type="password" placeholder="Ievadi paroli" name="Parole" class="w-full border-none bg-transparent outline-none placeholder:italic focus:outline-none">
                </div>    
                
                <button type="submit">Pieslēgties</button>
            
                <label> 
                <input type="checkbox" checked="checked" name="remember"> Atcerēties mani
                </label>
            
                <button type="button" class="Atceltpoga">Atcelt</button>
                <span class="Password">Aizmirsi <a href="#">paroli?</a></span>
                </div>
            </div>
        </div>
    </div>
</template>