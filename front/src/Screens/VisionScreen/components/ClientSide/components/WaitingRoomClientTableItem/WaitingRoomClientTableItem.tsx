import React from 'react';
import AnimateHeight from 'react-animate-height';

import PrimaryButton from '../../../../../../components/PrimaryButton';
import SecondaryButton from '../../../../../../components/SecondaryButton';

import { formatClientTime } from '../../utils';

import {
  DEFAULT_DURATION,
  RoundColor,
  useWaitingRoomClientTableItem,
  WaitingRoomClientTableItemProps
} from './useWaitingRoomClientTableItem';

const WaitingRoomClientTableItem = (props: WaitingRoomClientTableItemProps) => {
  const {
    client,
    height,
    editSaveButtonTitle,
    people,
    edit,
    onEditSaveClick,
    handleClick,
    handleClose,
    onPeopleIncrease,
    onPeopleDecrease,
  } = useWaitingRoomClientTableItem(props);

  return (
    <>
      <tr
        className={`table__clickable ${edit ? 'disabled' : ''}`}
        onClick={handleClick}
      >
        <td style={{ backgroundColor: '#FF3400' }} />
        <td>{formatClientTime(client.start_time)}</td>
        <td>{formatClientTime(client.visit_time)}</td>
        <td>{formatClientTime(client.waiting_time)}</td>
        <td>
          {edit && (
            <button onClick={onPeopleDecrease} type="button">-</button>
          )}
          <span className="table__clickable-people">{people}</span>
          {edit && (
            <button onClick={onPeopleIncrease} type="button">+</button>
          )}
        </td>
        <td>
          <span
            className="table__clickable-round"
            style={{ backgroundColor: RoundColor[`${client.children}`] }}
          />
        </td>
        <td>
          <span
            className="table__clickable-round"
            style={{ backgroundColor: RoundColor[`${client.in_progress}`] }}
          />
        </td>
        <td>
          <span
            className="table__clickable-round"
            style={{ backgroundColor: RoundColor[`${client.representative_arrived}`] }}
          />
        </td>
      </tr>
      <AnimateHeight
        duration={DEFAULT_DURATION}
        height={height}
      >
        <div className="table__info">
          <div className="table__closeIcon">
            <img src="/images/x.svg" alt="close" onClick={handleClose} />
          </div>
          <div className="grid-center-trio table__info-grid">
            <div className="table__textBlock">
              <span className="title">
                Нотаріус
              </span>
              <span className="info">
                {client.notary.map(({ title, id }) => (
                  <span key={id}>{title}</span>
                ))}
              </span>
            </div>

            <div className="table__textBlock">
              <span className="title">
                Читач
              </span>
              <span className="info">
                {client.reader.map(({ title, id }) => (
                  <span key={id}>{title}</span>
                ))}
              </span>
            </div>

            <div className="table__textBlock">
              <span className="title">
                Видавач
              </span>
              <span className="info">
                {client.accompanying.map(({ title, id }) => (
                  <span key={id}>{title}</span>
                ))}
              </span>
            </div>

            <div className="table__textBlock">
              <span className="title">
                Підписант
              </span>
              <span className="info">
                {client.representative.map(({ title, id }) => (
                  <span key={id}>{title}</span>
                ))}
              </span>
            </div>

            <div className="table__textBlock">
              <span className="title">
                Нерухомість
              </span>
              <span className="info">
                {client.immovable.map(({ title, id }) => (
                  <span key={id}>{title}</span>
                ))}
              </span>
            </div>

            <div className="table__textBlock">
              <span className="title">
                Покупець
              </span>
              <span className="info">
                {client.buyer.map(({ title, id }) => (
                  <span key={id}>{title}</span>
                ))}
              </span>
            </div>
          </div>

          <div className="table__buttonsGroup">
            <SecondaryButton
              label={editSaveButtonTitle}
              onClick={onEditSaveClick}
              disabled={false}
            />
            <SecondaryButton
              label="Переглянути"
              onClick={() => console.log('click')}
              disabled={false}
            />
            <PrimaryButton
              label="Завершити послугу"
              onClick={() => console.log('click')}
            />
          </div>

        </div>
      </AnimateHeight>
    </>
  );
};

export default WaitingRoomClientTableItem;