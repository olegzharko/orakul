import React from 'react';

type AssistantRoomCardProps = {
  color: string;
  name: string;
  startTime: string;
  accompanying: string;
  read: string;
  generate: string;
}

const AssistantRoomCard = ({
  color,
  name,
  startTime,
  accompanying,
  read,
  generate,
}: AssistantRoomCardProps) => (
  <div
    className="employee"
  >
    <div
      className="employee__mark"
      style={{ backgroundColor: color }}
    />

    <div className="employee__main">
      <div className="employee__header">
        <img src="/images/user.svg" alt="user" />
        <span>{name}</span>
      </div>

      <div className="employee__body">
        <div className="indicator">
          <img src="/images/clock.svg" alt="clock" />
          <span>{startTime}</span>
        </div>

        <div className="indicator">
          <img src="/images/file.svg" alt="file" />
          <span>{accompanying}</span>
        </div>

        <div className="indicator">
          <img src="/images/pencil.svg" alt="pencil" />
          <span>{read}</span>
        </div>

        <div className="indicator">
          <img src="/images/table.svg" alt="table" />
          <span>{generate}</span>
        </div>
      </div>
    </div>
  </div>
);

export default AssistantRoomCard;
