<?php

namespace App\Filament\Resources\CommentResource\Widgets;

use App\Filament\Resources\CommentResource;
use App\Models\Comment;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestComment extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Comment::whereDate('created_at','>',Carbon::now()->subDays(14)->startOfDay())
            )
            ->columns([
                TextColumn::make('comment'),
                TextColumn::make('created_at')->date(),
                TextColumn::make('user.name'),
                TextColumn::make('post.title'),
            ])
            ->actions([
                Tables\Actions\Action::make('View')
                ->url(fn (Comment $record) : string => CommentResource::getUrl('edit',['record'=>$record])),
            ]);
    }
}
