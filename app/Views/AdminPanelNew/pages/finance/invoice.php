<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }

        .tablewidth {
            width: 100%;
        }

        .row {
            margin-bottom: 10px;
        }

        .col-6 {
            width: 50%;
            float: left;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #aaa;
            text-align: left;
        }

        th {
            background: #CED4D4;
        }

        .text_bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="tablewidth">
        <div class="row">
            <div class="col-6">
                <h4>BILL From :</h4>
                <p class="text_bold">Address: Kalidas marg, kila road, Maheshwar, Madhya Pradesh 451224</p>
                <p class="text_bold">City: Dewas</p>
                <p class="text_bold">Email: info@thehilmen.com</p>
            </div>
            <div class="col-6" style="text-align: center;">
                <img src="https://hillmen.brillsense.com/FrontTheme/images/the-hillmen-logo.png" width="150">
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <h4>BILL TO :</h4>
                <p class="text_bold">Name: <?= $orderDetails[0]['fullname'] ?? 'Not Available' ?>,</p>
                <p class="text_bold">Name: <?= $orderDetails[0]['email'] ?? 'Not Available' ?>,</p>
                <p class="text_bold">Name: <?= $orderDetails[0]['mobile'] ?? 'Not Available' ?>,</p>
                <p class="text_bold">Address: <?= $orderDetails[0]['billing_address'] ?? 'Not Available' ?>,</p>
                <p class="text_bold">City: <?= $orderDetails[0]['city_name'] ?? 'Not Available' ?></p>

            </div>
            <div class="col-6">
                <table>
                    <tbody>
                        <tr>
                            <td class="text_bold">Invoice #</td>
                            <td style="text-align: right"><?= $orderDetails[0]['order_number'] ?></td>
                        </tr>
                        <tr>
                            <td class="text_bold">Invoice Date</td>
                            <td style="text-align: right"><?= date('F j, Y', strtotime($orderDetails[0]['order_date'])) ?></td>
                        </tr>
                        <tr>
                            <td class="text_bold" style="background-color: #CDD2D5;">Order Amount</td>
                            <td style="text-align: right">₹<?= number_format($orderDetails[0]['order_total'], 2) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>PRODUCT NAME</th>
                    <th>SIZE-COLOR</th>
                    <th>QUANTITY</th>
                    <th>RATE</th>
                    <th>TOTAL AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderDetails[0]['items'] as $item): ?>
                    <tr>
                        <td class="no"><?= $item['product_name'] ?></td>

                        <td><?= $item['size_name'] . ' - ' . $item['color_name'] ?></td>
                        <td><?= $item['order_qty'] ?></td>
                        <td>₹<?= number_format($item['purches_rate'], 2) ?></td>
                        <td>₹<?= number_format($item['item_total_amount'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="row">
            <!-- <div class="col-6">
                <h5>Notes/Memo</h5>
                <p>Free Shipping with 30 days money back</p>
            </div> -->
            <div class="col-6">
                <table>
                    <tbody>
                        <tr>
                            <td class="text_bold">SUBTOTAL</td>
                            <td style="text-align: right">₹<?= number_format($orderDetails[0]['purchase_total'], 2) ?></td>
                        </tr>
                         <tr>
                            <td class="text_bold">DISCOUNT TOTAL</td>
                            <td style="text-align: right">
                                ₹<?= number_format($orderDetails[0]['purchase_total'] - $orderDetails[0]['order_total'], 2) ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text_bold">TAXABLE TOTAL</td>
                            <td style="text-align: right">₹<?= number_format($orderDetails[0]['taxable_total'], 2) ?></td>
                        </tr>
                        <tr>
                            <td class="text_bold">GST TOTAL</td>
                            <td style="text-align: right">₹<?= number_format($orderDetails[0]['gst_total'], 2) ?></td>
                        </tr>
                       
                        <?php if ($orderDetails[0]['coupon_dis_total'] > 0): ?>
                            <tr>
                                <td class="text_bold">COUPON</td>
                                <td style="text-align: right">₹<?= number_format($orderDetails[0]['coupon_dis_total'], 2) ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($orderDetails[0]['shipping_charges_total'] > 0): ?>
                            <tr>
                                <td class="text_bold">SHIPPING</td>
                                <td style="text-align: right">₹<?= number_format($orderDetails[0]['shipping_charges_total'], 2) ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr style="background-color: #CDD2D5">
                            <td class="text_bold">GRAND TOTAL</td>
                            <td style="text-align: right">₹<?= number_format($orderDetails[0]['order_total'], 2) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>