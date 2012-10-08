<?php

/*
 * This file is part of the RuudkMoneybirdBundle package.
 *
 * (c) Ruud Kamphuis <ruudk@mphuis.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ruudk\MoneybirdBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResetCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this->setName('moneybird:reset');
        $this->setDescription('Deletes all invoices and contacts from a Moneybird account');
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelperSet()->get('dialog');

        $output->writeln(array(
            '',
            $this->getHelperSet()->get('formatter')->formatBlock(sprintf(
                'This will delete all invoices and contacts from %s.moneybird.nl',
                $this->getContainer()->getParameter('ruudk_moneybird.subdomain')
            ), 'bg=red;fg=white', true),
            '',
        ));

        $moneybird = $this->getContainer()->get('moneybird.api');

        $contactService = $moneybird->getService('Contact');
        $contacts = $contactService->getAll();

        $invoiceService = $moneybird->getService('Invoice');
        $invoices = $invoiceService->getAll();

        $output->writeLn(sprintf(
            '<info>Found %s and %s</info> ',
            count($contacts) == 1 ? "1 contact" : count($contacts) . " contacts",
            count($invoices) == 1 ? "1 invoice" : count($invoices) . " invoices"
        ));

        if(count($contacts) == 0 && count($invoices) == 0)
        {
            $output->writeln(array(
                '',
                $this->getHelperSet()->get('formatter')->formatBlock('Nothing to do', 'bg=blue;fg=white', true),
                '',
            ));

            return;
        }

        $output->writeLn('');

        if (!$dialog->askConfirmation($output, '<question>Are you sure you want to do this?</question> ', false)) {
            return;
        }

        foreach($invoices AS $invoice)
        {
            $invoice->delete($invoiceService);
        }

        foreach($contacts AS $contact)
        {
            $contact->delete($contactService);
        }

        $output->writeln(array(
            '',
            $this->getHelperSet()->get('formatter')->formatBlock('Done!', 'bg=blue;fg=white', true),
            '',
        ));
    }
}