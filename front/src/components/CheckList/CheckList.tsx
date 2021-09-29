import React from 'react';
import CustomCheckBox from '../CustomCheckBox';

import PrimaryButton from '../PrimaryButton';
import SecondaryButton from '../SecondaryButton';

import './index.scss';

export type CheckListItem = {
  date_time: string;
  id: number;
  status: boolean;
  title: string;
  onChange: () => void;
}

type CheckListProps = {
  checkList: CheckListItem[];
  onSave: (item: CheckListItem) => void;
  onCancel: () => void;
}

const CheckList = ({ checkList, onSave, onCancel }: CheckListProps) => (
  <div className="check-list">
    <div className="title">Чек-лист</div>
    <div className="list">
      {checkList.map(({ id, status, title, onChange }) => (
        <CustomCheckBox
          key={id}
          label={title}
          checked={status}
          onChange={onChange}
        />
      ))}
    </div>
    <div className="buttons">
      <PrimaryButton
        label="Зберегти"
        onClick={onSave}
      />
      <SecondaryButton
        label="Закрити"
        onClick={onCancel}
        disabled={false}
      />
    </div>
  </div>
);

export default CheckList;
