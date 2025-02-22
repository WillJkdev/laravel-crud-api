<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportStudentsFromCSV extends Command
{

    protected $signature = 'import:students {file}'; // Argumento: Ruta del archivo CSV
    protected $description = 'Importar estudiantes desde un archivo CSV';
    public function handle()
    {
        $filePath = $this->argument('file');

        if (!file_exists($filePath)) {
            $this->error("El archivo no existe: $filePath");
            return;
        }

        $file = fopen($filePath, 'r');
        $header = fgetcsv($file); // Leer la primera fila (encabezado)

        while ($row = fgetcsv($file)) {
            $data = array_combine($header, $row); // Convertir a array asociativo

            Student::create([
                'id' => (string) Str::uuid(), // Generar UUID aquí
                'student_names' => $data['student_names'],
                'phone' => $data['phone'],
                'math' => $data['math'],
                'physics' => $data['physics'],
                'chemistry' => $data['chemistry'],
                'grade' => $data['grade'],
                'comment' => $data['comment'],
                'student_address' => $data['student_address'],
            ]);
        }

        fclose($file);
        $this->info("Importación completada con éxito.");
    }
}

//php artisan import:students storage/app/estudiantes.csv
//docker exec -it laravel_app php artisan import:students storage/app/estudiantes.csv
