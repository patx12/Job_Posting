<form method="POST" action="/admin-setup/register">
    @csrf

    <div>
        <label>Name</label>
        <input type="text" name="name" required />
        @error('name') <span>{{ $message }}</span> @enderror
    </div>

    <div>
        <label>Email</label>
        <input type="email" name="email" required />
        @error('email') <span>{{ $message }}</span> @enderror
    </div>

    <div>
        <label>Password</label>
        <input type="password" name="password" required />
    </div>

    <div>
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" required />
    </div>

    <div>
        <label>Secret Key</label>
        <input type="password" name="secret" required />
        @error('secret') <span style="color:red">{{ $message }}</span> @enderror
    </div>

    <button type="submit">Create Admin</button>
</form>