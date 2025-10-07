 <div class="w-full max-w-6xl">
     <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
         <div class="p-6 md:p-8">
             <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Pilih Paket Langganan</h2>
             <p class="text-gray-600 text-center mb-8">Pilih paket yang sesuai dengan kebutuhan SPBU Anda.</p>
             <form wire:submit.prevent="subscribe">
                 <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                     @foreach ($plans as $index => $plan)
                         <div
                             class="card bg-base-100 border border-gray-300 shadow-xl transition-all duration-300 {{ $selectedPlan == $plan->id ? 'ring-4 ring-primary ring-opacity-50' : '' }} relative overflow-hidden h-full">
                             @if ($index == 1)
                                 <div class="absolute top-4 right-4">
                                     <span class="badge badge-success badge-lg">⭐ Populer</span>
                                 </div>
                             @endif
                             <div class="card-body text-center p-6 flex flex-col h-full">
                                 <div
                                     class="w-12 h-12 bg-primary rounded-full flex items-center justify-center mx-auto mb-3">
                                     <span class="icon-[tabler--package] text-white size-6"></span>
                                 </div>
                                 <h3 class="card-title justify-center text-lg font-bold text-gray-800">
                                     {{ $plan->name }}</h3>
                                 <div class="my-4">
                                     <span class="text-4xl font-extrabold text-primary">Rp
                                         {{ number_format($plan->price, 0, ',', '.') }}</span>
                                     <p class="text-sm text-gray-600 font-medium">/bulan</p>
                                 </div>
                                 <div class="divider my-4"></div>
                                 <ul class="space-y-2 text-sm mb-6 flex-grow">
                                     @foreach ($plan->features as $feature)
                                         <li class="flex items-center justify-center text-gray-700">
                                             <span class="icon-[tabler--circle-check] text-success size-5 mr-2"></span>
                                             <span class="font-medium">{{ $feature }}</span>
                                         </li>
                                     @endforeach
                                 </ul>
                                 <div class="card-actions justify-center mt-auto">
                                     @if ($plan->price == 0)
                                         <button type="button" wire:click="confirmTrial({{ $plan->id }})"
                                             class="btn btn-outline w-full cursor-pointer transition-all">
                                             <span class="icon-[tabler--check] size-4 mr-2"></span>
                                             Coba Gratis
                                         </button>
                                     @else
                                         <label
                                             class="btn btn-outline w-full {{ $selectedPlan == $plan->id ? 'btn-active' : '' }} cursor-pointer transition-all">
                                             <input type="radio" wire:model="selectedPlan" value="{{ $plan->id }}"
                                                 class="hidden" />
                                             <span class="icon-[tabler--check] size-4 mr-2"></span>
                                             Pilih Paket
                                         </label>
                                     @endif
                                 </div>
                             </div>
                         </div>
                     @endforeach
                 </div>

                 @if ($selectedPlan)
                     @php $selectedPlanObj = $plans->find($selectedPlan); @endphp
                     @if ($selectedPlanObj && $selectedPlanObj->price > 0)
                         <div class="text-center">
                             <button type="submit" class="btn btn-primary btn-lg">
                                 Pilih Paket
                                 <span class="icon-[tabler--arrow-right] size-4 ml-2"></span>
                             </button>
                         </div>
                     @endif
                 @endif
             </form>
         </div>
     </div>

     <div class="mt-6 text-center">
         <p class="text-sm text-gray-600">
             &copy; 2025 Antrianku. All rights reserved.
         </p>
     </div>
 </div>
