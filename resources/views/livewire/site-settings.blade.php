<div>
    <div class="field">
        <label for="site-title" class="field__label">
            Title
        </label>

        <input
            wire:model="title"
            id="site-title"
            class="field__input"
        />
    </div>

    <div class="field">
        <label for="site-description" class="field__label">
            Description
        </label>

        <textarea
            wire:model="description"
            id="site-description"
            class="field__input field__input--textarea"
        ></textarea>
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
