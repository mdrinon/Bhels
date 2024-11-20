<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

use MongoDB\Client as MongoClient;

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    try {
        // Connect to MongoDB
        $client = new MongoClient("mongodb://localhost:27017");
        $collection = $client->bheldb->orders;

        // Prepare the order data
        $orderData = [
            'dateOrdered' => new MongoDB\BSON\UTCDateTime(),
            'quantity' => (int)($data['quantity'] ?? 1),
            'subTotal' => (int)$data['subTotal'],
            'shippingFee' => (int)$data['shippingFee'],
            'orderTotal' => (int)$data['orderTotal'],
            'deliveryDetails' => [
                'delivery_date' => new MongoDB\BSON\UTCDateTime(strtotime($data['delivery_date']) * 1000),
                'delivery_time' => $data['delivery_time'],
                'delivery_address' => $data['delivery_address'],
                'contact_person' => [
                    'contact_person_name' => $data['recipient_name'],
                    'contact_person_number' => $data['recipient_phone']
                ]
            ],
            'CustomerDetails' => [
                'customer_id' => new MongoDB\BSON\ObjectId($data['customer_id']),
                'customer_name' => $data['customer_name'],
                'customer_username' => $data['customer_username'],
                'customerContact' => [
                    'customer_contact_number' => $data['customer_phone'],
                    'customer_contact_email' => $data['customer_email']
                ]
            ],
            'PlacedOrderDetails' => $data['PlacedOrderDetails'],
            'PaymentDetails' => [
                'payment_status' => 'Pending',
                'payment_date' => null
            ],
            'order_status' => 'Pending'
        ];

        // Insert the order data into the 'orders' collection
        $result = $collection->insertOne($orderData);

        echo json_encode(['success' => true, 'order_id' => $result->getInsertedId()]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
}
?>
