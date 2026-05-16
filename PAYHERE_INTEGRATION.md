# PayHere Payment Gateway Integration

This document provides instructions for setting up and using the PayHere payment gateway integration for the Mirissawaves booking system.

## Overview

The PayHere integration allows customers to make secure online payments for package bookings. The system supports both authenticated users and guest bookings with automatic account creation.

## Setup Instructions

### 1. PayHere Account Setup

1. **Create PayHere Account**: Sign up at [PayHere](https://www.payhere.lk/)
2. **Get Merchant Credentials**:
   - Log into your PayHere account
   - Navigate to 'Integrations' section
   - Copy your Merchant ID
3. **Generate Merchant Secret**:
   - Click 'Add Domain/App' in the Integrations section
   - Enter your domain name (e.g., `yourdomain.com`)
   - Request approval (may take up to 24 hours)
   - Once approved, copy the Merchant Secret

### 2. Environment Configuration

Add the following variables to your `.env` file:

```env
# PayHere Payment Gateway Configuration
PAYHERE_MERCHANT_ID=your_merchant_id_here
PAYHERE_MERCHANT_SECRET=your_merchant_secret_here
PAYHERE_SANDBOX_MODE=true
```

**Important**: Set `PAYHERE_SANDBOX_MODE=false` for production.

### 3. Database Migration

Run the migration to add payment fields to the bookings table:

```bash
php artisan migrate
```

## Features

### Payment Flow

1. **Booking Creation**: Customer fills out booking form
2. **Payment Initialization**: System redirects to PayHere payment page
3. **Payment Processing**: Customer completes payment on PayHere
4. **Return Handling**: PayHere redirects back with payment status
5. **Notification Processing**: PayHere sends server-to-server notifications
6. **Booking Confirmation**: Booking status updated based on payment result

### Payment Statuses

- `pending`: Payment initiated but not completed
- `paid`: Payment successful, booking confirmed
- `failed`: Payment failed
- `cancelled`: Payment cancelled by user

### Security Features

- **Hash Verification**: All PayHere communications are verified using HMAC-SHA256
- **Order ID Validation**: Unique order IDs prevent duplicate payments
- **Amount Verification**: Payment amounts are verified against booking totals

## API Endpoints

### Payment Routes

- `GET /payhere/initialize?booking_id={id}` - Initialize payment
- `POST /payhere/return` - Handle successful payment return
- `POST /payhere/cancel` - Handle payment cancellation
- `POST /payhere/notify` - Handle PayHere notifications
- `GET /booking/{id}/success` - Payment success page
- `GET /booking/{id}/failed` - Payment failed page

### PayHere URLs

- **Sandbox**: `https://sandbox.payhere.lk/pay/checkout`
- **Live**: `https://www.payhere.lk/pay/checkout`

## Testing

### Sandbox Testing

1. Set `PAYHERE_SANDBOX_MODE=true` in your `.env` file
2. Use PayHere sandbox test credentials
3. Test with sandbox test cards:
   - **Visa**: 4111111111111111
   - **Mastercard**: 5555555555554444
   - **Expiry**: Any future date
   - **CVV**: Any 3 digits

### Test Scenarios

1. **Successful Payment**: Complete payment flow
2. **Failed Payment**: Use invalid card details
3. **Cancelled Payment**: Cancel during payment process
4. **Network Issues**: Test notification handling

## Production Deployment

### Pre-deployment Checklist

- [ ] Set `PAYHERE_SANDBOX_MODE=false`
- [ ] Update PayHere domain configuration
- [ ] Test with real payment methods
- [ ] Verify SSL certificate is active
- [ ] Test notification URLs are accessible
- [ ] Update email templates for production

### Domain Configuration

1. Add your production domain to PayHere account
2. Update Merchant Secret for production domain
3. Ensure notification URLs are publicly accessible
4. Test all payment flows in production environment

## Monitoring and Logs

### Log Files

Payment-related logs are stored in `storage/logs/laravel.log`:

- Payment initialization
- Return URL processing
- Notification handling
- Error tracking

### Key Log Messages

- `PayHere return error:` - Return URL processing errors
- `PayHere notify error:` - Notification processing errors
- `PayHere notify: Payment status updated` - Successful status updates

## Troubleshooting

### Common Issues

1. **Hash Verification Failed**
   - Check Merchant Secret configuration
   - Verify order ID format
   - Ensure amount formatting is correct

2. **Payment Not Processing**
   - Check PayHere account status
   - Verify domain configuration
   - Test with sandbox mode first

3. **Notifications Not Received**
   - Ensure notification URL is publicly accessible
   - Check server firewall settings
   - Verify PayHere domain configuration

### Support

For PayHere-specific issues:
- PayHere Support: [support.payhere.lk](https://support.payhere.lk)
- Documentation: [PayHere API Docs](https://support.payhere.lk/api-%26-mobile-sdk/checkout-api)

For application issues:
- Check Laravel logs
- Verify database migrations
- Test with sandbox environment

## Security Considerations

1. **Never expose Merchant Secret** in client-side code
2. **Always verify payment amounts** before processing
3. **Use HTTPS** for all payment-related communications
4. **Implement proper error handling** for failed payments
5. **Log all payment activities** for audit purposes

## Future Enhancements

Potential improvements to consider:

1. **Multiple Payment Methods**: Add support for other gateways
2. **Payment Plans**: Implement installment payments
3. **Refund Handling**: Add refund processing capabilities
4. **Payment Analytics**: Add payment reporting and analytics
5. **Mobile Optimization**: Enhance mobile payment experience
