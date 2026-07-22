<!DOCTYPE html>
<html>
<body style="padding: 30px; font-family: Arial, sans-serif;">
    <h2>1. Mag-add ng Payment Dito</h2>
    <form action="/payments" method="POST">
        @csrf
        <label>Method (GCash/Maya):</label>
        <input type="text" name="method" required>
        <label>Amount:</label>
        <input type="number" name="amount" required>
        <button type="submit" style="background: blue; color: white; padding: 5px 10px;">Save to Database</button>
    </form>
    
    <br><hr><br>

    <h2>2. Mga Pumasok sa Database</h2>
    <table border="1" cellpadding="10" style="border-collapse: collapse; width: 100%;">
        <tr style="background: #eee;">
            <th>Transaction ID</th>
            <th>Method</th>
            <th>Amount</th>
            <th>Status</th>
        </tr>
        @foreach($payments as $payment)
        <tr>
            <td>{{ $payment->transaction_id }}</td>
            <td>{{ $payment->method }}</td>
            <td>₱{{ $payment->amount }}</td>
            <td>{{ $payment->status }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
