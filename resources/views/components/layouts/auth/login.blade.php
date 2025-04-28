<div>
    <div class="min-h-screen flex items-center justify-center bg-blue-50" style="background-color: #f0f4ff;">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-lg shadow-md overflow-hidden" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="bg-gray-800 text-white py-4 px-6" style="background-color: #2C3245;">
                    <h2 class="text-xl font-semibold text-center">Login Page</h2>
                </div>
                
                <div class="p-6">
                    <form wire:submit="login" class="space-y-6">
                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-2" style="color: #4a5568; font-weight: 500;">Email</label>
                            <input type="email" 
                                   id="email" 
                                   wire:model="email" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;"
                                   required>
                            @error('email') <span class="text-red-500 text-sm" style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label for="password" class="block text-gray-700 font-medium mb-2" style="color: #4a5568; font-weight: 500;">Password</label>
                            <input type="password" 
                                   id="password" 
                                   wire:model="password" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;"
                                   required>
                            @error('password') <span class="text-red-500 text-sm" style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="flex justify-center" style="display: flex; justify-content: center;">
                            <button type="submit" 
                                    class="bg-gray-700 hover:bg-gray-800 text-white font-medium py-2 px-6 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    style="background-color: #2C3245; color: white; font-weight: 500; padding: 0.5rem 1.5rem; border-radius: 0.375rem;">
                                Login
                            </button>
                        </div>
                        
                        @if (session()->has('error'))
                            <div class="mt-4 p-3 bg-red-100 text-red-700 rounded-md text-center" 
                                 style="margin-top: 1rem; padding: 0.75rem; background-color: #fee2e2; color: #b91c1c; border-radius: 0.375rem; text-align: center;">
                                {{ session('error') }}
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .min-h-screen {
            min-height: 100vh;
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
            background-color: #f0f4ff;
        }
        
        .w-full {
            width: 100%;
        }
        
        .max-w-md {
            max-width: 28rem;
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
        
        .bg-gray-800 {
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
        }
        
        .space-y-6 > * + * {
            margin-top: 1.5rem;
        }
        
        .block {
            display: block;
        }
        
        .text-gray-700 {
            color: #4a5568;
        }
        
        .font-medium {
            font-weight: 500;
        }
        
        .mb-2 {
            margin-bottom: 0.5rem;
        }
        
        button[type="submit"] {
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        button[type="submit"]:hover {
            background-color: #1e293b;
        }
    </style>
</div>
