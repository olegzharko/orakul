import React from 'react';
import { useSchedulerLock } from './useSchedulerLock';
import './index.scss';

const SchedulerLock = () => {
  const { onClick, schedulerLock } = useSchedulerLock();

  return (
    <div className={`scheduler__lock-button ${schedulerLock ? '' : 'unLock'}`}>
      <img src="/icons/lock.svg" alt="lock" onClick={onClick} />
    </div>
  );
};

export default SchedulerLock;
