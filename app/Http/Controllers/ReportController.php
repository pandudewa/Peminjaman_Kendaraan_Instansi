<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Type;

class ReportController extends Controller
{
    public function exportBookings()
    {
        $bookings = Booking::all();

        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser('bookings.xlsx');

        $headerRow = WriterEntityFactory::createRowFromArray([
            'Vehicle', 'Driver', 'Date', 'Status'
        ]);
        $writer->addRow($headerRow);

        foreach ($bookings as $booking) {
            $dataRow = WriterEntityFactory::createRowFromArray([
                $booking->vehicle->name,
                $booking->driver->name,
                $booking->date,
                $booking->status,
            ]);
            $writer->addRow($dataRow);
        }

        $writer->close();
    }
}
