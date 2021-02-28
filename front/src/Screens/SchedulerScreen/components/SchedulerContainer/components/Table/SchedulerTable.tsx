import React from 'react';
import './index.scss';
import { v4 as uuidv4 } from 'uuid';
import { useSchedulerTable } from './useSchedulerTable';
import Loader from '../../../../../../components/Loader';

// components
import SchedulerDay from './components/SchedulerDay/SchedulerDay';
import GridLayout from './components/GridLayout/GridLayout';
import GridTable from './components/GridTable/GridTable';

const SchedulerTable = () => {
  const {
    shouldLoad,
    rooms,
    hours,
    tableRaws,
    tableColumns,
    days,
    appointments,
    handleAppointmentDrag,
  } = useSchedulerTable();

  if (shouldLoad) {
    return <Loader />;
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
          <GridTable raws={tableRaws} columns={tableColumns} />
          <GridLayout
            appointments={appointments}
            cols={tableColumns.length}
            handleDrag={handleAppointmentDrag}
          />
        </div>
      </div>
    </div>
  );
};

export default SchedulerTable;
