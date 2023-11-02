<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Group Currency Form Fields
    |--------------------------------------------------------------------------
    |
    | The list of fields in the group currency form and their names for display.
    |
    */

    // This is the configuration for the group currency form presented to users when submitting pieces to the gallery.
    // It can be configured to your liking, though this configuration is presented as an example.
    // The precise formula for group currency awards is more or less hardcoded; it takes values from this form
    // and performs basic operations (addition, multiplication) to arrive at the final number.
    // In an effort to make it accessible, the function that countains it has been placed in app/Helpers/AssetHelpers, at the top.

    // Form names shouldn't have spaces, only underscores (_) like these examples.
    // Configuration values are given in pairs of keys and values, arranged like so:
    // 'key' => 'value'
    // and sometimes in arrays, like this:
    // ['key1' => 'value1', 'key2' => 'value2']
    // For multiple choice questions, for example the one immediately below, the options 'art', 'lit', etc
    // are hidden to the user, and the values are displayed instead. Rather, the keys are sent to be processed when
    // the form is submitted. Using this, we can have options that are secretly numeric values for the currency formula,
    // but appear to the user as human-readable options!

    // Each of these has a key, 'label', which corresponds to the form's label as displayed.

    // For convenience, this first field has all the possible options/keys, with each commented on!
    'piece_type'  => [
        // This is the name as will be displayed on submissions, not the form itself.
        'name'     => 'Type of Piece',
        // This is the label as will be displayed on the form itself, so provide any instruction for the user filling out the form here.
        'label'    => 'Piece Type (Select as many as apply)',
        // The type of form. In this case, since the user is picking from several options, it's "choice"!
        'type'     => 'choice',
        // These are the choices themselves. The key is what the form outputs, and the value is the text shown to the user.
        'choices'  => ['art' => 'Digital or Traditional Art', 'lit' => 'Writing and Poetry', '3d' => '3D art', 'craft' => 'Craft or Other Physical Item'],
        // This makes this field required!
        'rules'    => 'required',
        // This allows the user to select multiple options! You don't need to set it at all unless you want it to be true,
        // since it will otherwise assume false.
        'multiple' => true,
        // For checkboxes/toggles, this is what the toggle outputs when "on".
        'value'    => null,
    ],
    'art_finish'  => [
        'name'    => 'Level of Finish',
        'label'   => 'Level of Finish (For Digital/Traditional Artwork)',
        'type'    => 'choice',
        'choices' => ['0' => 'Sketch', '12.5' => 'Clean Lines/Lineless', '25' => 'Painted'],
    ],
    'art_type'    => [
        'name'    => 'Art Type',
        'label'   => 'Art Type (For Digital/Traditional Artwork)',
        'type'    => 'choice',
        'choices' => ['0' => 'Headshot', '5' => 'Bust', '12.5' => 'Full Body Chibi', '25' => 'Full Body'],
    ],
    'art_bonus'   => [
        'name'     => 'Art Bonuses',
        'type'     => 'choice',
        'label'    => 'Bonus Options (For Digital/Traditional Artwork, Select as many as apply)',
        // If you wish to have options with all the same value, in this case 1, give them a .1 difference,
        // which can easily be rounded out, but allows for the computer to distinguish between them.
        'choices'  => ['10' => 'Colored', '7.5' => 'Shading', '15' => 'Background'],
        'multiple' => true,
    ],
    'art_finish3d'  => [
        'name'    => 'Level of Finish',
        'label'   => 'Level of Finish (For 3D rendered Artwork)',
        'type'    => 'choice',
        'choices' => ['0' => 'No texture/Flat color textures', '12.5' => 'Textured, basic lighting', '19' => 'Dynamic lighting/composition detail'],
    ],
    'model_type'    => [
        'name'    => 'Model type',
        'label'   => 'Model Type (For 3D rendered Artwork)',
        'type'    => 'choice',
        'choices' => ['0' => 'Pre-existing/Pre-submitted model', '10' => 'Model created with base/assets', '25' => 'Model created from scratch'],
    ],
    'art_bonus3d'   => [
        'name'     => 'Art Bonuses',
        'type'     => 'choice',
        'label'    => 'Bonus Options (For 3D rendered Artwork, Select as many as apply)',
        // If you wish to have options with all the same value, in this case 1, give them a .1 difference,
        // which can easily be rounded out, but allows for the computer to distinguish between them.
        'choices'  => ['11' => 'Self-arranged scene', '10' => 'Added 2d Effects', '20' => 'Extra rigging (ie hair or clothing bones)'],
        'multiple' => true,
    ],
    'base'        => [
        'name'  => 'On Base/YCH',
        'label' => 'Base (P2U/F2U) or YCH',
        // This makes the option a toggle!
        'type'  => 'checkbox',
        'value' => 1,
    ],
    'frame_count' => [
        'name'  => 'Frame Count',
        'label' => 'Frame Count (For Animations, enter keyframes for tweened animation)',
        // This makes a field the user can enter a number in!
        'type'  => 'number',
    ],
    'word_count'  => [
        'name'  => 'Word Count',
        'label' => 'Word Count (For Writing or Poetry)',
        'type'  => 'number',
    ],

];
