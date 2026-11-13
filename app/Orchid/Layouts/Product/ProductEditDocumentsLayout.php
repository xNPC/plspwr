<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Product;

use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class ProductEditDocumentsLayout extends Rows
{
    public function fields(): array
    {
        return [
            Upload::make('product.documents')
                ->title('Файлы документации')
                ->multiple()
                ->acceptedFiles('.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv,.rtf,.zip,image/*')
                ->help('Руководства, спецификации, сертификаты, схемы и прочие материалы к изделию: PDF, Word, Excel, изображения, архивы. Файлы показываются на странице продукта в разделе «Документация».'),
        ];
    }
}
