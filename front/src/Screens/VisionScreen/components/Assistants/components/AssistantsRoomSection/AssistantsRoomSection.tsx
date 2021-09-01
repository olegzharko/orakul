import React from 'react';

import AssistantRoomCard from '../AssistantRoomCard';

type AssistantsRoomSectionProps = {
  title: string;
  employees: any;
}

const AssistantsRoomSection = ({ title, employees }: AssistantsRoomSectionProps) => (
  <div className="room-section">
    <div className="room-section__header">
      <span>{title}</span>
    </div>
    <div className="room-section__body">
      {employees.map((employee: any) => (
        <AssistantRoomCard
          key={employee.name}
          color={employee.color}
          name={employee.name}
          startTime={employee.startTime}
          set={employee.set}
          reading={employee.reading}
          issuance={employee.issuance}
        />
      ))}
    </div>
  </div>
);

export default AssistantsRoomSection;
