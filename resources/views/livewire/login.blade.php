

<div>
    <div class="min-h-screen flex items-center justify-center bg-blue-50" style="justify-content: center;">
        <div class="w-full lebar-margin ">
            <div class="bg-white rounded-lg shadow-md overflow-hidden" style="box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.25);">
                <div class="bg-gray-dark text-white py-3 px-6" style="background-color: #2C3245;">
                    <h2 class="text-xl font-semibold text-center">Login Page</h2>
                </div>
                
                <div class="p-6">
                    <form wire:submit="login">
                           
                        @if (session()->has('error'))
                            <div class=" mb-3 p-3 bg-red-100 text-red-700 rounded-md text-center" 
                                 style=" background-color: #fee2e2; color: #b91c1c; border-radius: 0.375rem; text-align: center;">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div>
                            <label for="email" class="mb-2" style="color: #4a5568; font-weight: 500;">Email</label>
                            <input type="email" 
                                   id="email" 
                                   wire:model="email" 
                                   class="w-full px-3 py-2 rounded-md "
                                   
                                   required>
                            @error('email') <span class="text-red-500 text-sm" style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label for="password" class="mb-2" style="color: #4a5568; font-weight: 500;margin-top: 1.5rem;">Password</label>
                            <input type="password" 
                                   id="password" 
                                   wire:model="password" 
                                   class="w-full px-3 py-2 rounded-md "
                                   
                                   required>
                            @error('password') <span class="text-red-500 text-sm" style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span> @enderror
                        </div>
                        
                        <div style="display: flex; justify-content: center;">
                            <button type="submit" 
                                    class="hover:bg-gray-dark text-white font-medium py-2 px-6 rounded-md focus:outline-none focus:ring-0"
                                    style="">
                                Login
                            </button>
                        </div>
                     
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .min-h-screen {
            min-height: calc(100vh);
        }
        
        .flex {
            display: flex;
        }
        
        .items-center {
            align-items: center;
        }
        
        .justify-center {
            justify-content: center;
        }
        
        .bg-blue-50 {
            background-color: #D5E0FF;
        }
        
        .w-full {
            width: 100%;
        }
        
        .lebar-margin {
            max-width: 28rem;
            margin:15px;
        }
        
        .bg-white {
            background-color: white;
        }
        
        .rounded-lg {
            border-radius: 0.5rem;
        }
        
        .shadow-md {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .overflow-hidden {
            overflow: hidden;
        }
        
        .bg-gray-dark {
            background-color: #2C3245;
        }
        
        .text-white {
            color: white;
        }
        
        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        
        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        
        .p-6 {
            padding: 1.5rem;
            background-color: #E4EBFF;
        }
        
        .mb-2 {
            margin-bottom: 0.5rem;
        }
        
        button[type="submit"] {
            cursor: pointer;
            transition: background-color 0.2s;
            border: none;
            outline: none;
            box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.25);
            background-color: #3B4B7A; 
            color: white; font-weight: 500; 
            padding: 1rem 3rem; 
            border-radius: 0.375rem; 
            margin-top: 1.5rem;
            
        }
        
        button[type="submit"]:hover {
            background-color: #1e293b;
        }
        
        button[type="submit"]:focus {
            background-color: #2e3a5e; 
        }

        input[type="email"],
        input[type="password"] {
            border: 1px solid #8EABFF;
            display: block;
            color: #4a5568;
            font-weight: 500;
            width: 100%; 
            padding: 0.5rem 0.75rem; 
            border-radius: 0.5rem;
        }
        
        
    </style>
</div>
