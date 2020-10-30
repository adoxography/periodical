<div>
    <div class="field">
        <label for="username" class="field__label">
            Name
        </label>

        <input
            id="username"
            class="field__input field__input--text"
            type="text"
            wire:model="user.name"
            value="{{ $user->name }}"
            required
        />
    </div>

    <div class="field">
        <label for="email" class="field__label">
            Email
        </label>

        <input
            id="email"
            class="field__input field__input--text"
            type="email"
            wire:model="user.email"
            value="{{ $user->email }}"
            required
        />
    </div>

    <div class="field">
        <label for="bio" class="field__label">
            Bio
        </label>

        <textarea
            id="bio"
            class="field__input field__input--textarea"
            wire:model="user.bio"
        ></textarea>
    </div>

    <div class="field field--image previewed-upload">
        <label class="btn previewed-upload__input">
            Change profile picture
            <input type="file" wire:model="image" />
        </label>

        <img src="{{ isset($image) ? $image->temporaryUrl() : $user->avatar_url }}" class="previewed-upload__preview" />
    </div>

    <div class="field field--center">
        <button
            wire:click="save"
            class="field__submit-btn btn"
            wire:loading.class="la-ball-clip-rotate"
            wire:target="save"
        >
            <span wire:loading.remove wire:target="save">
                Save
            </span>
        </button>
    </div>
</div>
