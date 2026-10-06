<?php

return [
    // Booking
    'schedule_unavailable' => 'This class schedule is not available.',
    'need_membership' => 'You need an active membership with remaining quota to book a class.',
    'already_booked_date' => 'You already booked this class for this date.',
    'overlap_booking' => 'You already have a booking at this time. Please choose another schedule.',
    'only_runs_on' => 'This class only runs on :day.',
    'booked_ok' => 'Class booked successfully.',
    'booked_waiting' => 'Class is full. You are on the waiting list.',
    'booked_in' => 'Booked and checked in.',
    'booked_in_remain' => 'Booked and checked in. Remaining quota: :count.',
    'already_checked_in' => 'This booking is already checked in.',
    'only_confirmed_checkin' => 'Only confirmed bookings can check in.',
    'checkin_day_only' => 'Check-in is only available on the class day.',
    'no_quota_checkin' => 'No active membership with remaining quota. Check-in blocked.',
    'checkin_stale' => 'This booking can no longer check in.',
    'checked_in_ok' => 'Checked in successfully.',
    'checked_in_remain' => 'Checked in successfully. Remaining quota: :count.',
    'cannot_cancel' => 'This booking cannot be cancelled.',
    'cancel_cutoff' => 'Bookings can only be cancelled at least 2 hours before the class starts.',
    'cancel_ok' => 'Booking cancelled.',
    'rate_ok' => 'Thanks for rating the class.',
    'member_no_quota' => ':name has no active membership with remaining quota.',
    'member_already_in' => ':name is already checked in.',
    'member_checked_in' => ':name checked in successfully.',
    'member_checked_in_remain' => ':name checked in successfully. Remaining quota: :count.',

    // Orders
    'order_approve_ok' => 'Order marked as paid. Membership activated.',
    'order_only_pending_approve' => 'Only pending orders can be approved.',
    'order_no_option' => 'This order has no package option to activate.',
    'order_only_pending_reject' => 'Only pending orders can be rejected.',
    'order_rejected' => 'Order rejected.',
    'proof_pending_only' => 'Proof can only be uploaded for pending orders.',
    'proof_ok' => 'Transfer proof uploaded. Please wait for admin verification.',
    'option_unavailable' => 'The selected package option is not available.',
    'package_unavailable' => 'The selected package is not available.',
    'package_unavailable_now' => 'This package is no longer available.',
    'active_package_block' => 'You still have an active package. You can only buy the same package again until it expires.',
    'member_active_package_block' => 'This member still has a different active package.',
    'order_created' => 'Order created successfully.',
    'order_pending_exists' => 'You already have a pending order for this option. Please complete the payment.',
    'reorder_created' => 'New order created. Please complete the payment.',
    'reorder_only_failed' => 'Only failed or expired orders can be ordered again.',
    'reorder_impossible' => 'This order cannot be ordered again.',
    'order_owner_missing' => 'Order owner not found.',

    // Account & profile
    'user_not_found' => 'User not found.',
    'profile_ok' => 'Profile updated successfully.',
    'sumber_ok' => 'Thank you! Your WhatsApp number and information source have been successfully saved.',

    // Notifications
    'notif_read_all' => 'All notifications marked as read.',
];
