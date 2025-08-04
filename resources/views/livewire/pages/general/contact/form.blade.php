<form wire:submit="submitMessage">
    <div class="inputs">
        <label>Full Name</label>
        <input type="text" wire:model.blur="name" placeholder="Full Name">
        <x-form-input-error field="name" />
    </div>

    <div class="inputs">
        <label>Phone Number</label>
        <input type="text" wire:model.blur="phone_number" placeholder="Phone Number">
        <x-form-input-error field="phone_number" />
    </div>

    <div class="inputs">
        <label>Email</label>
        <input type="email" wire:model.blur="email" placeholder="Email">
        <x-form-input-error field="email" />
    </div>

    <div class="inputs">
        <label>Message</label>
        <textarea rows="4" wire:model.blur="message" placeholder="What can we do for you?"></textarea>
        <x-form-input-error field="message" />
    </div>

    <button type="submit" wire:loading.attr="disabled" wire:target="submitMessage">
        <span wire:loading.remove wire:target="submitMessage">Send Message</span>
        <span wire:loading wire:target="submitMessage">Sending...</span>
    </button>
</form>
