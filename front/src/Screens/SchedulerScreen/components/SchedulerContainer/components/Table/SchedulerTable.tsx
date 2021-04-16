import React from 'react';
import './index.scss';
import { v4 as uuidv4 } from 'uuid';

// components
import { useSchedulerTable } from './useSchedulerTable';
import Loader from '../../../../../../components/Loader/Loader';
import SchedulerDay from './components/SchedulerDay/SchedulerDay';
import GridLayout from './components/GridLayout/GridLayout';
import GridTable from './components/GridTable/GridTable';

const SchedulerTable = () => {
  const {
    shouldLoad,
    rooms,
    hours,
    tableRows,
    tableColumns,
    days,
    appointments,
    handleAppointmentDrag,
    onAppointmentClick,
  } = useSchedulerTable();

  if (shouldLoad) {
    return (
      <div className="scheduler">
        <Loader />
      </div>
    );
  }

  return (
    <div className="scheduler">
      <div className="scheduler__header">
        <div />
        <div>
          <table>
            <tbody>
              <tr>
                {rooms.map(({ title }: any) => (
                  <td
                    key={title}
                    style={{ width: `calc(100% / ${rooms.length})` }}
                  >
                    {title}
                  </td>
                ))}
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div className="scheduler__body">
        <div className="scheduler__dayBar">
          {days.map((item: any) => (
            <SchedulerDay day={item} hours={hours} key={uuidv4()} />
          ))}
        </div>
        <div className="scheduler__appointments">
          <GridTable rows={tableRows} columns={tableColumns} />
          <GridLayout
            appointments={appointments}
            cols={tableColumns.length}
            handleDrag={handleAppointmentDrag}
            handleClick={onAppointmentClick}
          />
        </div>
      </div>
    </div>
  );
};

export default SchedulerTable;
