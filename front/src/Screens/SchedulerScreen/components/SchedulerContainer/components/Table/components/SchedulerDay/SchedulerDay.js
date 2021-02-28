/* eslint-disable react/prop-types */
import React from 'react';
import './SchedulerDay.scss';

const SchedulerDay = ({ day, hours }) => (
  <div className="scheduler__weekDay">
    <div className="scheduler__day">
      <p>
        {day.day}
        <br />
        {day.date}
      </p>
    </div>
    <div className="scheduler__timeLine">
      {hours.map(({ time }) => (
        <p key={time}>{time}</p>
      ))}
    </div>
  </div>
);

export default SchedulerDay;
