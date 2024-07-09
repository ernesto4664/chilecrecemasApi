<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComunasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comunas')->insert([
            ['id' => 1, 'nombre' => 'Arica', 'region_id' => 1],
            ['id' => 2, 'nombre' => 'Camarones', 'region_id' => 1],
            ['id' => 3, 'nombre' => 'Putre', 'region_id' => 1],
            ['id' => 4, 'nombre' => 'General Lagos', 'region_id' => 1],
            ['id' => 5, 'nombre' => 'Iquique', 'region_id' => 2],
            ['id' => 6, 'nombre' => 'Alto Hospicio', 'region_id' => 2],
            ['id' => 7, 'nombre' => 'Pozo Almonte', 'region_id' => 2],
            ['id' => 8, 'nombre' => 'Camiña', 'region_id' => 2],
            ['id' => 9, 'nombre' => 'Colchane', 'region_id' => 2],
            ['id' => 10, 'nombre' => 'Huara', 'region_id' => 2],
            ['id' => 11, 'nombre' => 'Pica', 'region_id' => 2],
            ['id' => 12, 'nombre' => 'Antofagasta', 'region_id' => 3],
            ['id' => 13, 'nombre' => 'Mejillones', 'region_id' => 3],
            ['id' => 14, 'nombre' => 'Sierra Gorda', 'region_id' => 3],
            ['id' => 15, 'nombre' => 'Taltal', 'region_id' => 3],
            ['id' => 16, 'nombre' => 'Calama', 'region_id' => 3],
            ['id' => 17, 'nombre' => 'Ollagüe', 'region_id' => 3],
            ['id' => 18, 'nombre' => 'San Pedro de Atacama', 'region_id' => 3],
            ['id' => 19, 'nombre' => 'Tocopilla', 'region_id' => 3],
            ['id' => 20, 'nombre' => 'María Elena', 'region_id' => 3],
            ['id' => 21, 'nombre' => 'Copiapó', 'region_id' => 4],
            ['id' => 22, 'nombre' => 'Caldera', 'region_id' => 4],
            ['id' => 23, 'nombre' => 'Tierra Amarilla', 'region_id' => 4],
            ['id' => 24, 'nombre' => 'Chañaral', 'region_id' => 4],
            ['id' => 25, 'nombre' => 'Diego de Almagro', 'region_id' => 4],
            ['id' => 26, 'nombre' => 'Vallenar', 'region_id' => 4],
            ['id' => 27, 'nombre' => 'Alto del Carmen', 'region_id' => 4],
            ['id' => 28, 'nombre' => 'Freirina', 'region_id' => 4],
            ['id' => 29, 'nombre' => 'Huasco', 'region_id' => 4],
            ['id' => 30, 'nombre' => 'La Serena', 'region_id' => 5],
            ['id' => 31, 'nombre' => 'Coquimbo', 'region_id' => 5],
            ['id' => 32, 'nombre' => 'Andacollo', 'region_id' => 5],
            ['id' => 33, 'nombre' => 'La Higuera', 'region_id' => 5],
            ['id' => 34, 'nombre' => 'Paiguano', 'region_id' => 5],
            ['id' => 35, 'nombre' => 'Vicuña', 'region_id' => 5],
            ['id' => 36, 'nombre' => 'Illapel', 'region_id' => 5],
            ['id' => 37, 'nombre' => 'Canela', 'region_id' => 5],
            ['id' => 38, 'nombre' => 'Los Vilos', 'region_id' => 5],
            ['id' => 39, 'nombre' => 'Salamanca', 'region_id' => 5],
            ['id' => 40, 'nombre' => 'Ovalle', 'region_id' => 5],
            ['id' => 41, 'nombre' => 'Combarbalá', 'region_id' => 5],
            ['id' => 42, 'nombre' => 'Monte Patria', 'region_id' => 5],
            ['id' => 43, 'nombre' => 'Punitaqui', 'region_id' => 5],
            ['id' => 44, 'nombre' => 'Río Hurtado', 'region_id' => 5],
            ['id' => 45, 'nombre' => 'Valparaíso', 'region_id' => 6],
            ['id' => 46, 'nombre' => 'Casablanca', 'region_id' => 6],
            ['id' => 47, 'nombre' => 'Concón', 'region_id' => 6],
            ['id' => 48, 'nombre' => 'Juan Fernández', 'region_id' => 6],
            ['id' => 49, 'nombre' => 'Puchuncaví', 'region_id' => 6],
            ['id' => 50, 'nombre' => 'Quintero', 'region_id' => 6],
            ['id' => 51, 'nombre' => 'Viña del Mar', 'region_id' => 6],
            ['id' => 52, 'nombre' => 'Isla de Pascua', 'region_id' => 6],
            ['id' => 53, 'nombre' => 'Los Andes', 'region_id' => 6],
            ['id' => 54, 'nombre' => 'Calle Larga', 'region_id' => 6],
            ['id' => 55, 'nombre' => 'Rinconada', 'region_id' => 6],
            ['id' => 56, 'nombre' => 'San Esteban', 'region_id' => 6],
            ['id' => 57, 'nombre' => 'La Ligua', 'region_id' => 6],
            ['id' => 58, 'nombre' => 'Cabildo', 'region_id' => 6],
            ['id' => 59, 'nombre' => 'Papudo', 'region_id' => 6],
            ['id' => 60, 'nombre' => 'Petorca', 'region_id' => 6],
            ['id' => 61, 'nombre' => 'Zapallar', 'region_id' => 6],
            ['id' => 62, 'nombre' => 'Quillota', 'region_id' => 6],
            ['id' => 63, 'nombre' => 'Calera', 'region_id' => 6],
            ['id' => 64, 'nombre' => 'Hijuelas', 'region_id' => 6],
            ['id' => 65, 'nombre' => 'La Cruz', 'region_id' => 6],
            ['id' => 66, 'nombre' => 'Nogales', 'region_id' => 6],
            ['id' => 67, 'nombre' => 'San Antonio', 'region_id' => 6],
            ['id' => 68, 'nombre' => 'Algarrobo', 'region_id' => 6],
            ['id' => 69, 'nombre' => 'Cartagena', 'region_id' => 6],
            ['id' => 70, 'nombre' => 'El Quisco', 'region_id' => 6],
            ['id' => 71, 'nombre' => 'El Tabo', 'region_id' => 6],
            ['id' => 72, 'nombre' => 'Santo Domingo', 'region_id' => 6],
            ['id' => 73, 'nombre' => 'San Felipe', 'region_id' => 6],
            ['id' => 74, 'nombre' => 'Catemu', 'region_id' => 6],
            ['id' => 75, 'nombre' => 'Llaillay', 'region_id' => 6],
            ['id' => 76, 'nombre' => 'Panquehue', 'region_id' => 6],
            ['id' => 77, 'nombre' => 'Putaendo', 'region_id' => 6],
            ['id' => 78, 'nombre' => 'Santa María', 'region_id' => 6],
            ['id' => 79, 'nombre' => 'Quilpué', 'region_id' => 6],
            ['id' => 80, 'nombre' => 'Limache', 'region_id' => 6],
            ['id' => 81, 'nombre' => 'Olmué', 'region_id' => 6],
            ['id' => 82, 'nombre' => 'Villa Alemana', 'region_id' => 6],
            ['id' => 83, 'nombre' => 'Rancagua', 'region_id' => 7],
            ['id' => 84, 'nombre' => 'Codegua', 'region_id' => 7],
            ['id' => 85, 'nombre' => 'Coinco', 'region_id' => 7],
            ['id' => 86, 'nombre' => 'Coltauco', 'region_id' => 7],
            ['id' => 87, 'nombre' => 'Doñihue', 'region_id' => 7],
            ['id' => 88, 'nombre' => 'Graneros', 'region_id' => 7],
            ['id' => 89, 'nombre' => 'Las Cabras', 'region_id' => 7],
            ['id' => 90, 'nombre' => 'Machalí', 'region_id' => 7],
            ['id' => 91, 'nombre' => 'Malloa', 'region_id' => 7],
            ['id' => 92, 'nombre' => 'Mostazal', 'region_id' => 7],
            ['id' => 93, 'nombre' => 'Olivar', 'region_id' => 7],
            ['id' => 94, 'nombre' => 'Peumo', 'region_id' => 7],
            ['id' => 95, 'nombre' => 'Pichidegua', 'region_id' => 7],
            ['id' => 96, 'nombre' => 'Quinta de Tilcoco', 'region_id' => 7],
            ['id' => 97, 'nombre' => 'Rengo', 'region_id' => 7],
            ['id' => 98, 'nombre' => 'Requínoa', 'region_id' => 7],
            ['id' => 99, 'nombre' => 'San Vicente', 'region_id' => 7],
            ['id' => 100, 'nombre' => 'Pichilemu', 'region_id' => 7],
            ['id' => 101, 'nombre' => 'La Estrella', 'region_id' => 7],
            ['id' => 102, 'nombre' => 'Litueche', 'region_id' => 7],
            ['id' => 103, 'nombre' => 'Marchihue', 'region_id' => 7],
            ['id' => 104, 'nombre' => 'Navidad', 'region_id' => 7],
            ['id' => 105, 'nombre' => 'Paredones', 'region_id' => 7],
            ['id' => 106, 'nombre' => 'San Fernando', 'region_id' => 7],
            ['id' => 107, 'nombre' => 'Chépica', 'region_id' => 7],
            ['id' => 108, 'nombre' => 'Chimbarongo', 'region_id' => 7],
            ['id' => 109, 'nombre' => 'Lolol', 'region_id' => 7],
            ['id' => 110, 'nombre' => 'Nancagua', 'region_id' => 7],
            ['id' => 111, 'nombre' => 'Palmilla', 'region_id' => 7],
            ['id' => 112, 'nombre' => 'Peralillo', 'region_id' => 7],
            ['id' => 113, 'nombre' => 'Placilla', 'region_id' => 7],
            ['id' => 114, 'nombre' => 'Pumanque', 'region_id' => 7],
            ['id' => 115, 'nombre' => 'Santa Cruz', 'region_id' => 7],
            ['id' => 116, 'nombre' => 'Talca', 'region_id' => 8],
            ['id' => 117, 'nombre' => 'Constitución', 'region_id' => 8],
            ['id' => 118, 'nombre' => 'Curepto', 'region_id' => 8],
            ['id' => 119, 'nombre' => 'Empedrado', 'region_id' => 8],
            ['id' => 120, 'nombre' => 'Maule', 'region_id' => 8],
            ['id' => 121, 'nombre' => 'Pelarco', 'region_id' => 8],
            ['id' => 122, 'nombre' => 'Pencahue', 'region_id' => 8],
            ['id' => 123, 'nombre' => 'Río Claro', 'region_id' => 8],
            ['id' => 124, 'nombre' => 'San Clemente', 'region_id' => 8],
            ['id' => 125, 'nombre' => 'San Rafael', 'region_id' => 8],
            ['id' => 126, 'nombre' => 'Cauquenes', 'region_id' => 8],
            ['id' => 127, 'nombre' => 'Chanco', 'region_id' => 8],
            ['id' => 128, 'nombre' => 'Pelluhue', 'region_id' => 8],
            ['id' => 129, 'nombre' => 'Curicó', 'region_id' => 8],
            ['id' => 130, 'nombre' => 'Hualañé', 'region_id' => 8],
            ['id' => 131, 'nombre' => 'Licantén', 'region_id' => 8],
            ['id' => 132, 'nombre' => 'Molina', 'region_id' => 8],
            ['id' => 133, 'nombre' => 'Rauco', 'region_id' => 8],
            ['id' => 134, 'nombre' => 'Romeral', 'region_id' => 8],
            ['id' => 135, 'nombre' => 'Sagrada Familia', 'region_id' => 8],
            ['id' => 136, 'nombre' => 'Teno', 'region_id' => 8],
            ['id' => 137, 'nombre' => 'Vichuquén', 'region_id' => 8],
            ['id' => 138, 'nombre' => 'Linares', 'region_id' => 8],
            ['id' => 139, 'nombre' => 'Colbún', 'region_id' => 8],
            ['id' => 140, 'nombre' => 'Longaví', 'region_id' => 8],
            ['id' => 141, 'nombre' => 'Parral', 'region_id' => 8],
            ['id' => 142, 'nombre' => 'Retiro', 'region_id' => 8],
            ['id' => 143, 'nombre' => 'San Javier', 'region_id' => 8],
            ['id' => 144, 'nombre' => 'Villa Alegre', 'region_id' => 8],
            ['id' => 145, 'nombre' => 'Yerbas Buenas', 'region_id' => 8],
            ['id' => 146, 'nombre' => 'Cobquecura', 'region_id' => 9],
            ['id' => 147, 'nombre' => 'Coelemu', 'region_id' => 9],
            ['id' => 148, 'nombre' => 'Ninhue', 'region_id' => 9],
            ['id' => 149, 'nombre' => 'Portezuelo', 'region_id' => 9],
            ['id' => 150, 'nombre' => 'Quirihue', 'region_id' => 9],
            ['id' => 151, 'nombre' => 'Ránquil', 'region_id' => 9],
            ['id' => 152, 'nombre' => 'Treguaco', 'region_id' => 9],
            ['id' => 153, 'nombre' => 'Bulnes', 'region_id' => 9],
            ['id' => 154, 'nombre' => 'Chillán Viejo', 'region_id' => 9],
            ['id' => 155, 'nombre' => 'Chillán', 'region_id' => 9],
            ['id' => 156, 'nombre' => 'El Carmen', 'region_id' => 9],
            ['id' => 157, 'nombre' => 'Pemuco', 'region_id' => 9],
            ['id' => 158, 'nombre' => 'Pinto', 'region_id' => 9],
            ['id' => 159, 'nombre' => 'Quillón', 'region_id' => 9],
            ['id' => 160, 'nombre' => 'San Ignacio', 'region_id' => 9],
            ['id' => 161, 'nombre' => 'Yungay', 'region_id' => 9],
            ['id' => 162, 'nombre' => 'Coihueco', 'region_id' => 9],
            ['id' => 163, 'nombre' => 'Ñiquén', 'region_id' => 9],
            ['id' => 164, 'nombre' => 'San Carlos', 'region_id' => 9],
            ['id' => 165, 'nombre' => 'San Fabián', 'region_id' => 9],
            ['id' => 166, 'nombre' => 'San Nicolás', 'region_id' => 9],
            ['id' => 167, 'nombre' => 'Concepción', 'region_id' => 10],
            ['id' => 168, 'nombre' => 'Coronel', 'region_id' => 10],
            ['id' => 169, 'nombre' => 'Chiguayante', 'region_id' => 10],
            ['id' => 170, 'nombre' => 'Florida', 'region_id' => 10],
            ['id' => 171, 'nombre' => 'Hualqui', 'region_id' => 10],
            ['id' => 172, 'nombre' => 'Lota', 'region_id' => 10],
            ['id' => 173, 'nombre' => 'Penco', 'region_id' => 10],
            ['id' => 174, 'nombre' => 'San Pedro de la Paz', 'region_id' => 10],
            ['id' => 175, 'nombre' => 'Santa Juana', 'region_id' => 10],
            ['id' => 176, 'nombre' => 'Talcahuano', 'region_id' => 10],
            ['id' => 177, 'nombre' => 'Tomé', 'region_id' => 10],
            ['id' => 178, 'nombre' => 'Hualpén', 'region_id' => 10],
            ['id' => 179, 'nombre' => 'Lebu', 'region_id' => 10],
            ['id' => 180, 'nombre' => 'Arauco', 'region_id' => 10],
            ['id' => 181, 'nombre' => 'Cañete', 'region_id' => 10],
            ['id' => 182, 'nombre' => 'Contulmo', 'region_id' => 10],
            ['id' => 183, 'nombre' => 'Curanilahue', 'region_id' => 10],
            ['id' => 184, 'nombre' => 'Los Álamos', 'region_id' => 10],
            ['id' => 185, 'nombre' => 'Tirúa', 'region_id' => 10],
            ['id' => 186, 'nombre' => 'Los Ángeles', 'region_id' => 10],
            ['id' => 187, 'nombre' => 'Antuco', 'region_id' => 10],
            ['id' => 188, 'nombre' => 'Cabrero', 'region_id' => 10],
            ['id' => 189, 'nombre' => 'Laja', 'region_id' => 10],
            ['id' => 190, 'nombre' => 'Mulchén', 'region_id' => 10],
            ['id' => 191, 'nombre' => 'Nacimiento', 'region_id' => 10],
            ['id' => 192, 'nombre' => 'Negrete', 'region_id' => 10],
            ['id' => 193, 'nombre' => 'Quilaco', 'region_id' => 10],
            ['id' => 194, 'nombre' => 'Quilleco', 'region_id' => 10],
            ['id' => 195, 'nombre' => 'San Rosendo', 'region_id' => 10],
            ['id' => 196, 'nombre' => 'Santa Bárbara', 'region_id' => 10],
            ['id' => 197, 'nombre' => 'Tucapel', 'region_id' => 10],
            ['id' => 198, 'nombre' => 'Yumbel', 'region_id' => 10],
            ['id' => 199, 'nombre' => 'Alto Biobío', 'region_id' => 10],
            ['id' => 200, 'nombre' => 'Temuco', 'region_id' => 11],
            ['id' => 201, 'nombre' => 'Carahue', 'region_id' => 11],
            ['id' => 202, 'nombre' => 'Cunco', 'region_id' => 11],
            ['id' => 203, 'nombre' => 'Curarrehue', 'region_id' => 11],
            ['id' => 204, 'nombre' => 'Freire', 'region_id' => 11],
            ['id' => 205, 'nombre' => 'Galvarino', 'region_id' => 11],
            ['id' => 206, 'nombre' => 'Gorbea', 'region_id' => 11],
            ['id' => 207, 'nombre' => 'Lautaro', 'region_id' => 11],
            ['id' => 208, 'nombre' => 'Loncoche', 'region_id' => 11],
            ['id' => 209, 'nombre' => 'Melipeuco', 'region_id' => 11],
            ['id' => 210, 'nombre' => 'Nueva Imperial', 'region_id' => 11],
            ['id' => 211, 'nombre' => 'Padre las Casas', 'region_id' => 11],
            ['id' => 212, 'nombre' => 'Perquenco', 'region_id' => 11],
            ['id' => 213, 'nombre' => 'Pitrufquén', 'region_id' => 11],
            ['id' => 214, 'nombre' => 'Pucón', 'region_id' => 11],
            ['id' => 215, 'nombre' => 'Saavedra', 'region_id' => 11],
            ['id' => 216, 'nombre' => 'Teodoro Schmidt', 'region_id' => 11],
            ['id' => 217, 'nombre' => 'Toltén', 'region_id' => 11],
            ['id' => 218, 'nombre' => 'Vilcún', 'region_id' => 11],
            ['id' => 219, 'nombre' => 'Villarrica', 'region_id' => 11],
            ['id' => 220, 'nombre' => 'Cholchol', 'region_id' => 11],
            ['id' => 221, 'nombre' => 'Angol', 'region_id' => 11],
            ['id' => 222, 'nombre' => 'Collipulli', 'region_id' => 11],
            ['id' => 223, 'nombre' => 'Curacautín', 'region_id' => 11],
            ['id' => 224, 'nombre' => 'Ercilla', 'region_id' => 11],
            ['id' => 225, 'nombre' => 'Lonquimay', 'region_id' => 11],
            ['id' => 226, 'nombre' => 'Los Sauces', 'region_id' => 11],
            ['id' => 227, 'nombre' => 'Lumaco', 'region_id' => 11],
            ['id' => 228, 'nombre' => 'Purén', 'region_id' => 11],
            ['id' => 229, 'nombre' => 'Renaico', 'region_id' => 11],
            ['id' => 230, 'nombre' => 'Traiguén', 'region_id' => 11],
            ['id' => 231, 'nombre' => 'Victoria', 'region_id' => 11],
            ['id' => 232, 'nombre' => 'Valdivia', 'region_id' => 12],
            ['id' => 233, 'nombre' => 'Corral', 'region_id' => 12],
            ['id' => 234, 'nombre' => 'Lanco', 'region_id' => 12],
            ['id' => 235, 'nombre' => 'Los Lagos', 'region_id' => 12],
            ['id' => 236, 'nombre' => 'Máfil', 'region_id' => 12],
            ['id' => 237, 'nombre' => 'Mariquina', 'region_id' => 12],
            ['id' => 238, 'nombre' => 'Paillaco', 'region_id' => 12],
            ['id' => 239, 'nombre' => 'Panguipulli', 'region_id' => 12],
            ['id' => 240, 'nombre' => 'La Unión', 'region_id' => 12],
            ['id' => 241, 'nombre' => 'Futrono', 'region_id' => 12],
            ['id' => 242, 'nombre' => 'Lago Ranco', 'region_id' => 12],
            ['id' => 243, 'nombre' => 'Río Bueno', 'region_id' => 12],
            ['id' => 244, 'nombre' => 'Puerto Montt', 'region_id' => 13],
            ['id' => 245, 'nombre' => 'Calbuco', 'region_id' => 13],
            ['id' => 246, 'nombre' => 'Cochamó', 'region_id' => 13],
            ['id' => 247, 'nombre' => 'Fresia', 'region_id' => 13],
            ['id' => 248, 'nombre' => 'Frutillar', 'region_id' => 13],
            ['id' => 249, 'nombre' => 'Los Muermos', 'region_id' => 13],
            ['id' => 250, 'nombre' => 'Llanquihue', 'region_id' => 13],
            ['id' => 251, 'nombre' => 'Maullín', 'region_id' => 13],
            ['id' => 252, 'nombre' => 'Puerto Varas', 'region_id' => 13],
            ['id' => 253, 'nombre' => 'Castro', 'region_id' => 13],
            ['id' => 254, 'nombre' => 'Ancud', 'region_id' => 13],
            ['id' => 255, 'nombre' => 'Chonchi', 'region_id' => 13],
            ['id' => 256, 'nombre' => 'Curaco de Vélez', 'region_id' => 13],
            ['id' => 257, 'nombre' => 'Dalcahue', 'region_id' => 13],
            ['id' => 258, 'nombre' => 'Puqueldón', 'region_id' => 13],
            ['id' => 259, 'nombre' => 'Queilén', 'region_id' => 13],
            ['id' => 260, 'nombre' => 'Quellón', 'region_id' => 13],
            ['id' => 261, 'nombre' => 'Quemchi', 'region_id' => 13],
            ['id' => 262, 'nombre' => 'Quinchao', 'region_id' => 13],
            ['id' => 263, 'nombre' => 'Osorno', 'region_id' => 13],
            ['id' => 264, 'nombre' => 'Puerto Octay', 'region_id' => 13],
            ['id' => 265, 'nombre' => 'Purranque', 'region_id' => 13],
            ['id' => 266, 'nombre' => 'Puyehue', 'region_id' => 13],
            ['id' => 267, 'nombre' => 'Río Negro', 'region_id' => 13],
            ['id' => 268, 'nombre' => 'San Juan de la Costa', 'region_id' => 13],
            ['id' => 269, 'nombre' => 'San Pablo', 'region_id' => 13],
            ['id' => 270, 'nombre' => 'Chaitén', 'region_id' => 13],
            ['id' => 271, 'nombre' => 'Futaleufú', 'region_id' => 13],
            ['id' => 272, 'nombre' => 'Hualaihué', 'region_id' => 13],
            ['id' => 273, 'nombre' => 'Palena', 'region_id' => 13],
            ['id' => 274, 'nombre' => 'Coihaique', 'region_id' => 14],
            ['id' => 275, 'nombre' => 'Lago Verde', 'region_id' => 14],
            ['id' => 276, 'nombre' => 'Aisén', 'region_id' => 14],
            ['id' => 277, 'nombre' => 'Cisnes', 'region_id' => 14],
            ['id' => 278, 'nombre' => 'Guaitecas', 'region_id' => 14],
            ['id' => 279, 'nombre' => 'Cochrane', 'region_id' => 14],
            ['id' => 280, 'nombre' => 'O’Higgins', 'region_id' => 14],
            ['id' => 281, 'nombre' => 'Tortel', 'region_id' => 14],
            ['id' => 282, 'nombre' => 'Chile Chico', 'region_id' => 14],
            ['id' => 283, 'nombre' => 'Río Ibáñez', 'region_id' => 14],
            ['id' => 284, 'nombre' => 'Punta Arenas', 'region_id' => 15],
            ['id' => 285, 'nombre' => 'Laguna Blanca', 'region_id' => 15],
            ['id' => 286, 'nombre' => 'Río Verde', 'region_id' => 15],
            ['id' => 287, 'nombre' => 'San Gregorio', 'region_id' => 15],
            ['id' => 288, 'nombre' => 'Cabo de Hornos (Ex Navarino)', 'region_id' => 15],
            ['id' => 289, 'nombre' => 'Antártica', 'region_id' => 15],
            ['id' => 290, 'nombre' => 'Porvenir', 'region_id' => 15],
            ['id' => 291, 'nombre' => 'Primavera', 'region_id' => 15],
            ['id' => 292, 'nombre' => 'Timaukel', 'region_id' => 15],
            ['id' => 293, 'nombre' => 'Natales', 'region_id' => 15],
            ['id' => 294, 'nombre' => 'Torres del Paine', 'region_id' => 15],
            ['id' => 295, 'nombre' => 'Cerrillos', 'region_id' => 16],
            ['id' => 296, 'nombre' => 'Cerro Navia', 'region_id' => 16],
            ['id' => 297, 'nombre' => 'Conchalí', 'region_id' => 16],
            ['id' => 298, 'nombre' => 'El Bosque', 'region_id' => 16],
            ['id' => 299, 'nombre' => 'Estación Central', 'region_id' => 16],
            ['id' => 300, 'nombre' => 'Huechuraba', 'region_id' => 16],
            ['id' => 301, 'nombre' => 'Independencia', 'region_id' => 16],
            ['id' => 302, 'nombre' => 'La Cisterna', 'region_id' => 16],
            ['id' => 303, 'nombre' => 'La Florida', 'region_id' => 16],
            ['id' => 304, 'nombre' => 'La Granja', 'region_id' => 16],
            ['id' => 305, 'nombre' => 'La Pintana', 'region_id' => 16],
            ['id' => 306, 'nombre' => 'La Reina', 'region_id' => 16],
            ['id' => 307, 'nombre' => 'Las Condes', 'region_id' => 16],
            ['id' => 308, 'nombre' => 'Lo Barnechea', 'region_id' => 16],
            ['id' => 309, 'nombre' => 'Lo Espejo', 'region_id' => 16],
            ['id' => 310, 'nombre' => 'Lo Prado', 'region_id' => 16],
            ['id' => 311, 'nombre' => 'Macul', 'region_id' => 16],
            ['id' => 312, 'nombre' => 'Maipú', 'region_id' => 16],
            ['id' => 313, 'nombre' => 'Ñuñoa', 'region_id' => 16],
            ['id' => 314, 'nombre' => 'Pedro Aguirre Cerda', 'region_id' => 16],
            ['id' => 315, 'nombre' => 'Peñalolén', 'region_id' => 16],
            ['id' => 316, 'nombre' => 'Providencia', 'region_id' => 16],
            ['id' => 317, 'nombre' => 'Pudahuel', 'region_id' => 16],
            ['id' => 318, 'nombre' => 'Quilicura', 'region_id' => 16],
            ['id' => 319, 'nombre' => 'Quinta Normal', 'region_id' => 16],
            ['id' => 320, 'nombre' => 'Recoleta', 'region_id' => 16],
            ['id' => 321, 'nombre' => 'Renca', 'region_id' => 16],
            ['id' => 322, 'nombre' => 'Santiago', 'region_id' => 16],
            ['id' => 323, 'nombre' => 'San Joaquín', 'region_id' => 16],
            ['id' => 324, 'nombre' => 'San Miguel', 'region_id' => 16],
            ['id' => 325, 'nombre' => 'San Ramón', 'region_id' => 16],
            ['id' => 326, 'nombre' => 'Vitacura', 'region_id' => 16],
            ['id' => 327, 'nombre' => 'Puente Alto', 'region_id' => 16],
            ['id' => 328, 'nombre' => 'Pirque', 'region_id' => 16],
            ['id' => 329, 'nombre' => 'San José de Maipo', 'region_id' => 16],
            ['id' => 330, 'nombre' => 'Colina', 'region_id' => 16],
            ['id' => 331, 'nombre' => 'Lampa', 'region_id' => 16],
            ['id' => 332, 'nombre' => 'Tiltil', 'region_id' => 16],
            ['id' => 333, 'nombre' => 'San Bernardo', 'region_id' => 16],
            ['id' => 334, 'nombre' => 'Buin', 'region_id' => 16],
            ['id' => 335, 'nombre' => 'Calera de Tango', 'region_id' => 16],
            ['id' => 336, 'nombre' => 'Paine', 'region_id' => 16],
            ['id' => 337, 'nombre' => 'Melipilla', 'region_id' => 16],
            ['id' => 338, 'nombre' => 'Alhué', 'region_id' => 16],
            ['id' => 339, 'nombre' => 'Curacaví', 'region_id' => 16],
            ['id' => 340, 'nombre' => 'María Pinto', 'region_id' => 16],
            ['id' => 341, 'nombre' => 'San Pedro', 'region_id' => 16],
            ['id' => 342, 'nombre' => 'Talagante', 'region_id' => 16],
            ['id' => 343, 'nombre' => 'El Monte', 'region_id' => 16],
            ['id' => 344, 'nombre' => 'Isla de Maipo', 'region_id' => 16],
            ['id' => 345, 'nombre' => 'Padre Hurtado', 'region_id' => 16],
            ['id' => 346, 'nombre' => 'Peñaflor', 'region_id' => 16],
        ]);
    }
}
