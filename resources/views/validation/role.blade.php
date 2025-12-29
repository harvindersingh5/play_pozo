<script>
    jQuery(document).ready(function() {
        const rules = {
            name: {
                required: true,
                maxlength: 255
            },
            'permissions[]': {
                required: true,
                minlength: 1
            },
        }
        const messages = {
            name: {
                required: "Role name is required.",
                maxlength: "Role name cannot be more than 255 characters."
            },
            'permissions[]': {
                required: "Please select at least one permission.",
                minlength: "Please select at least one permission."
            }

        };

        handleValidation('create-role', rules, messages);

    });
</script>
