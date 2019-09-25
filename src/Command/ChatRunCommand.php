<?php

namespace App\Command;

use App\Chat\Chat;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ChatRunCommand extends Command
{
    protected static $defaultName = 'chat:run';
    protected $chat;

    public function __construct(Chat $chat)
    {
        parent::__construct();

        $this->chat = $chat;
    }

    protected function configure()
    {
        $this
            ->setDescription('Lance un serveur WebSocket pour le chat');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        // Création d'un serveur WebSocket avec Ratchet
        $server = IoServer::factory(new HttpServer(new WsServer($this->chat)), 8081);

        $io->success('Le serveur de chat a été lancé et est prêt à communiquer');

        $server->run();
    }
}
