<?php
/**
 * Pdo.php
 * @author: jmoulin@castelis.com
 */

namespace Tests\Db\Driver;

class PdoMockDbDriverPdo extends \PDO
{
    public function __construct()
    {

    }
}

class PdoTest extends \PHPUnit_Framework_TestCase
{

    public function testGetDriver()
    {
        $pdoMock = $this->getMock(PdoMockDbDriverPdo::class);
        $pdo = $this->getMock(\FMUP\Db\Driver\Pdo::class, array('getPdo'));
        $pdo->expects($this->once())->method('getPdo')->willReturn($pdoMock);
        /** @var \FMUP\Db\Driver\Pdo $pdo */
        $this->assertInstanceOf(\FMUP\Db\Driver\PdoConfiguration::class, $pdo);
        $this->assertSame($pdoMock, $pdo->getDriver());
    }

    public function testBeginTransactionFailWhenAlreadyInTransaction()
    {
        $pdoMock = $this->getMock(PdoMockDbDriverPdo::class, array('inTransaction'));
        $pdoMock->expects($this->once())->method('inTransaction')->willReturn(true);
        $pdo = $this->getMock(\FMUP\Db\Driver\Pdo::class, array('getDriver'));
        $pdo->expects($this->once())->method('getDriver')->willReturn($pdoMock);
        /** @var \FMUP\Db\Driver\Pdo $pdo */
        $this->expectException(\FMUP\Db\Exception::class);
        $this->expectExceptionMessage('Transaction already opened');
        $pdo->beginTransaction();
    }

    public function testBeginTransactionFailRandom()
    {
        $pdoMock = $this->getMock(PdoMockDbDriverPdo::class, array('inTransaction'));
        $pdoMock->expects($this->once())->method('inTransaction')->willThrowException(new \PDOException('random message'));
        $pdo = $this->getMock(\FMUP\Db\Driver\Pdo::class, array('getDriver', 'log'));
        $pdo->expects($this->once())->method('getDriver')->willReturn($pdoMock);
        $pdo->expects($this->once())->method('log')->with($this->equalTo(\FMUP\Logger::ERROR), $this->equalTo('random message'));
        /** @var \FMUP\Db\Driver\Pdo $pdo */
        $this->expectException(\FMUP\Db\Exception::class);
        $this->expectExceptionMessage('random message');
        $pdo->beginTransaction();
    }

    public function testBeginTransaction()
    {
        $pdoMock = $this->getMock(PdoMockDbDriverPdo::class, array('inTransaction', 'beginTransaction'));
        $pdoMock->expects($this->once())->method('inTransaction')->willReturn(false);
        $pdoMock->expects($this->once())->method('beginTransaction')->willReturn(true);
        $pdo = $this->getMock(\FMUP\Db\Driver\Pdo::class, array('getDriver', 'log'));
        $pdo->method('getDriver')->willReturn($pdoMock);
        /** @var \FMUP\Db\Driver\Pdo $pdo */
        $this->assertTrue($pdo->beginTransaction());
    }

    public function testRollbackFailRandom()
    {
        $pdoMock = $this->getMock(PdoMockDbDriverPdo::class, array('rollBack'));
        $pdoMock->expects($this->once())->method('rollBack')->willThrowException(new \PDOException('random message'));
        $pdo = $this->getMock(\FMUP\Db\Driver\Pdo::class, array('getDriver', 'log'));
        $pdo->expects($this->once())->method('getDriver')->willReturn($pdoMock);
        $pdo->expects($this->once())->method('log')->with($this->equalTo(\FMUP\Logger::ERROR), $this->equalTo('random message'));
        /** @var \FMUP\Db\Driver\Pdo $pdo */
        $this->expectException(\FMUP\Db\Exception::class);
        $this->expectExceptionMessage('random message');
        $pdo->rollback();
    }

    public function testRollback()
    {
        $pdoMock = $this->getMock(PdoMockDbDriverPdo::class, array('rollBack'));
        $pdoMock->expects($this->once())->method('rollBack')->willReturn(true);
        $pdo = $this->getMock(\FMUP\Db\Driver\Pdo::class, array('getDriver', 'log'));
        $pdo->method('getDriver')->willReturn($pdoMock);
        /** @var \FMUP\Db\Driver\Pdo $pdo */
        $this->assertTrue($pdo->rollback());
    }

    public function testErrorCodeFailRandom()
    {
        $pdoMock = $this->getMock(PdoMockDbDriverPdo::class, array('errorCode'));
        $pdoMock->expects($this->once())->method('errorCode')->willThrowException(new \PDOException('random message'));
        $pdo = $this->getMock(\FMUP\Db\Driver\Pdo::class, array('getDriver', 'log'));
        $pdo->expects($this->once())->method('getDriver')->willReturn($pdoMock);
        $pdo->expects($this->once())->method('log')->with($this->equalTo(\FMUP\Logger::ERROR), $this->equalTo('random message'));
        /** @var \FMUP\Db\Driver\Pdo $pdo */
        $this->expectException(\FMUP\Db\Exception::class);
        $this->expectExceptionMessage('random message');
        $pdo->errorCode();
    }

    public function testErrorCode()
    {
        $pdoMock = $this->getMock(PdoMockDbDriverPdo::class, array('errorCode'));
        $pdoMock->expects($this->once())->method('errorCode')->willReturn(10);
        $pdo = $this->getMock(\FMUP\Db\Driver\Pdo::class, array('getDriver', 'log'));
        $pdo->method('getDriver')->willReturn($pdoMock);
        /** @var \FMUP\Db\Driver\Pdo $pdo */
        $this->assertSame(10, $pdo->errorCode());
    }

    public function testErrorInfoFailRandom()
    {
        $pdoMock = $this->getMock(PdoMockDbDriverPdo::class, array('errorInfo'));
        $pdoMock->expects($this->once())->method('errorInfo')->willThrowException(new \PDOException('random message'));
        $pdo = $this->getMock(\FMUP\Db\Driver\Pdo::class, array('getDriver', 'log'));
        $pdo->expects($this->once())->method('getDriver')->willReturn($pdoMock);
        $pdo->expects($this->once())->method('log')->with($this->equalTo(\FMUP\Logger::ERROR), $this->equalTo('random message'));
        /** @var \FMUP\Db\Driver\Pdo $pdo */
        $this->expectException(\FMUP\Db\Exception::class);
        $this->expectExceptionMessage('random message');
        $pdo->errorInfo();
    }

    public function testErrorInfo()
    {
        $pdoMock = $this->getMock(PdoMockDbDriverPdo::class, array('errorInfo'));
        $pdoMock->expects($this->once())->method('errorInfo')->willReturn(array());
        $pdo = $this->getMock(\FMUP\Db\Driver\Pdo::class, array('getDriver', 'log'));
        $pdo->method('getDriver')->willReturn($pdoMock);
        /** @var \FMUP\Db\Driver\Pdo $pdo */
        $this->assertSame(array(), $pdo->errorInfo());
    }

    public function testCommitFailRandom()
    {
        $pdoMock = $this->getMock(PdoMockDbDriverPdo::class, array('commit'));
        $pdoMock->expects($this->once())->method('commit')->willThrowException(new \PDOException('random message'));
        $pdo = $this->getMock(\FMUP\Db\Driver\Pdo::class, array('getDriver', 'log'));
        $pdo->expects($this->once())->method('getDriver')->willReturn($pdoMock);
        $pdo->expects($this->once())->method('log')->with($this->equalTo(\FMUP\Logger::ERROR), $this->equalTo('random message'));
        /** @var \FMUP\Db\Driver\Pdo $pdo */
        $this->expectException(\FMUP\Db\Exception::class);
        $this->expectExceptionMessage('random message');
        $pdo->commit();
    }

    public function testCommit()
    {
        $pdoMock = $this->getMock(PdoMockDbDriverPdo::class, array('commit'));
        $pdoMock->expects($this->once())->method('commit')->willReturn(true);
        $pdo = $this->getMock(\FMUP\Db\Driver\Pdo::class, array('getDriver', 'log'));
        $pdo->method('getDriver')->willReturn($pdoMock);
        /** @var \FMUP\Db\Driver\Pdo $pdo */
        $this->assertTrue($pdo->commit());
    }


    public function testExecuteFailNotStatement()
    {
        $pdo = $this->getMock(\FMUP\Db\Driver\Pdo::class, array('log'));
        $pdo->expects($this->once())->method('log')->with($this->equalTo(\FMUP\Logger::ERROR), $this->equalTo('Statement not in right format'));
        /** @var \FMUP\Db\Driver\Pdo $pdo */
        $this->expectException(\FMUP\Db\Exception::class);
        $this->expectExceptionMessage('Statement not in right format');
        $pdo->execute('sql');
    }

    public function testExecuteFailRandom()
    {
        $statement = $this->getMock(\PDOStatement::class, array('execute'));
        $statement->expects($this->once())->method('execute')->willThrowException(new \PDOException('random message'));
        $pdo = $this->getMock(\FMUP\Db\Driver\Pdo::class, array('log'));
        $pdo->expects($this->once())->method('log')->with($this->equalTo(\FMUP\Logger::ERROR), $this->equalTo('random message'));
        /** @var \FMUP\Db\Driver\Pdo $pdo */
        $this->expectException(\FMUP\Db\Exception::class);
        $this->expectExceptionMessage('random message');
        $pdo->execute($statement, array('test' => 'test'));
    }

    public function testExecute()
    {
        $statement = $this->getMock(\PDOStatement::class, array('execute'));
        $statement->expects($this->once())->method('execute')->with($this->equalTo(array('test' => 'test')))->willReturn(true);
        $pdo = new \FMUP\Db\Driver\Pdo;
        /** @var \FMUP\Db\Driver\Pdo $pdo */
        $this->assertTrue($pdo->execute($statement, array('test' => 'test')));
    }

    public function testPrepareFailRandom()
    {
        $pdoMock = $this->getMock(PdoMockDbDriverPdo::class, array('prepare'));
        $pdoMock->expects($this->once())->method('prepare')->willThrowException(new \PDOException('random message'));
        $pdo = $this->getMock(\FMUP\Db\Driver\Pdo::class, array('getDriver', 'log'));
        $pdo->expects($this->once())->method('getDriver')->willReturn($pdoMock);
        $pdo->expects($this->once())->method('log')->with($this->equalTo(\FMUP\Logger::ERROR), $this->equalTo('random message'));
        /** @var \FMUP\Db\Driver\Pdo $pdo */
        $this->expectException(\FMUP\Db\Exception::class);
        $this->expectExceptionMessage('random message');
        $pdo->prepare('sql');
    }

    public function testPrepare()
    {
        $statement = $this->getMock(\PDOStatement::class);
        $pdoMock = $this->getMock(PdoMockDbDriverPdo::class, array('prepare'));
        $pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($statement)
            ->with($this->equalTo('sql'), $this->equalTo(array('test' => 'test')));
        $pdo = $this->getMock(\FMUP\Db\Driver\Pdo::class, array('getDriver', 'log'));
        $pdo->method('getDriver')->willReturn($pdoMock);
        /** @var \FMUP\Db\Driver\Pdo $pdo */
        $this->assertSame($statement, $pdo->prepare('sql', array('test' => 'test')));
    }

    public function testLastInsertIdFailRandom()
    {
        $pdoMock = $this->getMock(PdoMockDbDriverPdo::class, array('lastInsertId'));
        $pdoMock->expects($this->once())->method('lastInsertId')->willThrowException(new \PDOException('random message'))->with($this->equalTo('sql'));
        $pdo = $this->getMock(\FMUP\Db\Driver\Pdo::class, array('getDriver', 'log'));
        $pdo->expects($this->once())->method('getDriver')->willReturn($pdoMock);
        $pdo->expects($this->once())->method('log')->with($this->equalTo(\FMUP\Logger::ERROR), $this->equalTo('random message'));
        /** @var \FMUP\Db\Driver\Pdo $pdo */
        $this->expectException(\FMUP\Db\Exception::class);
        $this->expectExceptionMessage('random message');
        $pdo->lastInsertId('sql');
    }

    public function testLastInsertId()
    {
        $pdoMock = $this->getMock(PdoMockDbDriverPdo::class, array('lastInsertId'));
        $pdoMock->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(10)
            ->with($this->equalTo(null));
        $pdo = $this->getMock(\FMUP\Db\Driver\Pdo::class, array('getDriver', 'log'));
        $pdo->method('getDriver')->willReturn($pdoMock);
        /** @var \FMUP\Db\Driver\Pdo $pdo */
        $this->assertSame(10, $pdo->lastInsertId());
    }

    public function testFetchAllFailNotStatement()
    {
        $pdo = $this->getMock(\FMUP\Db\Driver\Pdo::class, array('log'));
        $pdo->expects($this->once())->method('log')->with($this->equalTo(\FMUP\Logger::ERROR), $this->equalTo('Statement not in right format'));
        /** @var \FMUP\Db\Driver\Pdo $pdo */
        $this->expectException(\FMUP\Db\Exception::class);
        $this->expectExceptionMessage('Statement not in right format');
        $pdo->fetchAll('sql');
    }

    public function testFetchAllFailRandom()
    {
        $statement = $this->getMock(\PDOStatement::class, array('fetchAll'));
        $statement->expects($this->once())->method('fetchAll')->willThrowException(new \PDOException('random message'));
        $pdo = $this->getMock(\FMUP\Db\Driver\Pdo::class, array('log'));
        $pdo->expects($this->once())->method('log')->with($this->equalTo(\FMUP\Logger::ERROR), $this->equalTo('random message'));
        /** @var \FMUP\Db\Driver\Pdo $pdo */
        $this->expectException(\FMUP\Db\Exception::class);
        $this->expectExceptionMessage('random message');
        $pdo->fetchAll($statement);
    }

    public function testFetchAll()
    {
        $statement = $this->getMock(\PDOStatement::class, array('fetchAll'));
        $statement->expects($this->once())->method('fetchAll')->willReturn(array(array()))->with($this->equalTo(1));
        $pdo = $this->getMock(\FMUP\Db\Driver\Pdo::class, array('getFetchMode'));
        $pdo->expects($this->once())->method('getFetchMode')->willReturn(1);
        /** @var \FMUP\Db\Driver\Pdo $pdo */
        $this->assertSame(array(array()), $pdo->fetchAll($statement));
    }
}