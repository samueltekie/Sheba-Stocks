<!-- Left Sidebar Navigation -->
<nav class="fixed top-0 left-0 h-full w-40 bg-gray-900 text-white shadow-lg p-6 space-y-6">
        <ul class="space-y-4">
            <li>
                <a href="{{ route('stock.list') }}" class="flex items-center text-gray-300 hover:text-blue-400 transition">
                    <i class="fas fa-home mr-3"></i>Home
                </a>
            </li>
            <li>
                <a href="{{ route('profile.show') }}" class="flex items-center text-gray-300 hover:text-blue-400 transition">
                    <i class="fas fa-user-circle mr-3"></i>Profile
                </a>
            </li>
            <li>
                <a href="{{ route('wallet.show', ['id' => auth()->user()->id]) }}" class="flex items-center text-gray-300 hover:text-blue-400 transition">
                    <i class="fas fa-wallet mr-3"></i>Wallet
                </a>
            </li>
            <li>
                <a href="#" onclick="confirmLogout(event)" class="flex items-center text-red-400 hover:text-red-600 transition">
                    <i class="fas fa-sign-out-alt mr-3"></i>Logout
                </a>
            </li>
            
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
    </nav>
    <script>
    function confirmLogout(event) {
        event.preventDefault(); // Prevent the default link behavior
        if (confirm("Are you sure you want to logout?")) {
            document.getElementById('logout-form').submit(); // Submit the form if confirmed
        }
    }
</script>