@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-blue-50 p-6 rounded-lg">
            <h3 class="text-lg font-semibold text-blue-800">Total Users</h3>
            <p class="text-3xl font-bold text-blue-600">1,250</p>
        </div>
        <div class="bg-green-50 p-6 rounded-lg">
            <h3 class="text-lg font-semibold text-green-800">Revenue</h3>
            <p class="text-3xl font-bold text-green-600">$24,500</p>
        </div>
        <div class="bg-purple-50 p-6 rounded-lg">
            <h3 class="text-lg font-semibold text-purple-800">Tasks</h3>
            <p class="text-3xl font-bold text-purple-600">42</p>
        </div>
    </div>
    
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Quick Actions</h2>
        <div class="flex flex-wrap gap-4">
            <button class="btn btn-primary">Add New User</button>
            <button class="btn btn-secondary">Generate Report</button>
            <button class="btn btn-accent">Send Newsletter</button>
        </div>
    </div>
    
    <!-- Congratulations Modal Component -->
    <x-flyonui.congratulations-modal
        title="Setup Complete!"
        message="Your dashboard is now fully configured 🎉<br>You're ready to start using all features."
        thankYouMessage="Thank you for choosing our platform!"
        buttonText="Go to Settings"
        buttonAction="/settings"
        triggerText="Show Setup Confirmation"
    />
</div>
@endsection