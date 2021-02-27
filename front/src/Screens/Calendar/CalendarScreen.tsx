import React from 'react';
import './index.scss';
import { v4 as uuidv4 } from 'uuid';
import { useCalendarScreen } from './useCalendarScreen';
import Loader from '../../components/Loader';

// components
import SchedulerDay from './components/SchedulerDay/SchedulerDay';
import GridLayout from './components/GridLayout/GridLayout';
import GridTable from './components/GridTable/GridTable';

const CalendarScreen = () => {
  const {
    shouldLoad,
    rooms,
    hours,
    tableRaws,
    tableCells,
    days,
  } = useCalendarScreen();

  // dispatch(setLayouts(data.map((prop) => ({ ...prop, w: 1, h: 1 }))));

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
          {days.map((item) => (
            <SchedulerDay day={item} hours={hours} key={uuidv4()} />
          ))}
        </div>
        <div className="scheduler__appointments">
          <GridTable raws={tableRaws} cells={tableCells} />
          {/* <GridLayout /> */}
        </div>
      </div>
    </div>
  );
};

export default CalendarScreen;
