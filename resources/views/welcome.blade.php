<?php
App\Models\User::where('email', 'admin@example.com')->exists()