<?php

namespace Kraken\_Unit\Runtime\Command\Thread;

use Kraken\_Unit\Runtime\Command\_T\TCommand;
use Kraken\Runtime\Command\Thread\ThreadExistsCommand;
use Kraken\Throwable\Exception\Runtime\RejectionException;
use StdClass;

class ThreadExistsCommandTest extends TCommand
{
    /**
     * @var string
     */
    protected $class = ThreadExistsCommand::class;

    /**
     *
     */
    public function testApiCommand_InvokesProperAction()
    {
        $alias  = 'alias';
        $result = new StdClass;

        $command = $this->createCommand();
        $manager = $this->createManager();
        $manager
            ->expects($this->once())
            ->method('existsThread')
            ->with($alias)
            ->will($this->returnValue($result));

        $this->assertSame(
            $result,
            $this->callProtectedMethod(
                $command, 'command', [[ 'alias' => $alias ]]
            )
        );
    }

    /**
     *
     */
    public function testApiCommand_ThrowsException_WhenContextParamAliasDoesNotExist()
    {
        $this->setExpectedException(RejectionException::class);
        $command = $this->createCommand();

        $this->callProtectedMethod($command, 'command', [[]]);
    }
}
