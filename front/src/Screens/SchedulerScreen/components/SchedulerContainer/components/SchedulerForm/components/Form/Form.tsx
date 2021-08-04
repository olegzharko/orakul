/* eslint-disable indent */
/* eslint-disable react/destructuring-assignment */
/* eslint-disable jsx-a11y/click-events-have-key-events */
/* eslint-disable jsx-a11y/no-noninteractive-element-interactions */
import React, { memo } from 'react';
import RadioButtonsGroup from '../../../../../../../../components/RadioButtonsGroup';
import CustomSelect from '../../../../../../../../components/CustomSelect';
import './index.scss';
import Clients from './components/Clients/Clients';
import PrimaryButton from '../../../../../../../../components/PrimaryButton';
import Loader from '../../../../../../../../components/Loader/Loader';
import ImmovableContainer from './components/ImmovableContainer';
import { useForm, Props } from './useForm';
import ConfirmDialog from '../../../../../../../../components/ConfirmDialog';

const SchedulerForm = (props: Props) => {
  const meta = useForm(props);

  if (meta.shouldLoad) {
    return (
      <div className="schedulerForm">
        <Loader />
      </div>
    );
  }

  return (
    <div className="schedulerForm">
      <div className="schedulerForm__forms">
        <div className="schedulerForm__header">
          <p className="title">
            {meta.insideEdit || props.edit
              ? `Запис № ${props.selectedCard.i}`
              : 'Новий запис'}
          </p>
          {meta.insideEdit ? (
            <img
              src="/images/delete.svg"
              alt="delete"
              className="clear-icon"
              onClick={meta.onDeleteCardClick}
            />
          ) : (
            <img
              src="/images/clear.svg"
              alt="clear"
              className="clear-icon"
              onClick={meta.onClearAll}
            />
          )}
        </div>

        <div className="mv12">
          <RadioButtonsGroup
            buttons={
              meta.insideEdit
                ? meta.notaries.filter(
                    ({ id }: any) => id === meta.selectedNotaryId
                  )
                : meta.notaries
            }
            onChange={meta.onNotaryChange}
            selected={meta.selectedNotaryId}
            unicId="notaries"
          />
        </div>

        <div className="mv12">
          <CustomSelect
            required
            label="Забудовник"
            data={meta.developers}
            onChange={meta.onDeveloperChange}
            selectedValue={meta.selectedDeveloperId}
            disabled={meta.insideEdit || false}
          />
        </div>

        <div className="mv12">
          <CustomSelect
            onChange={meta.onRepresentativeChange}
            data={meta.representative}
            label="Підписант"
            selectedValue={meta.selectedDevRepresentativeId}
            disabled={meta.insideEdit || false}
          />
        </div>

        <div className="mv12">
          <CustomSelect
            onChange={meta.onManagerChange}
            data={meta.manager}
            label="Менеджер"
            selectedValue={meta.selectedDevManagerId}
            disabled={meta.insideEdit || false}
          />
        </div>

        <ImmovableContainer
          immovables={meta.immovables}
          onChange={meta.onImmovablesChange}
          onAdd={meta.onAddImmovables}
          onRemove={meta.onRemoveImmovable}
          disabled={meta.insideEdit || false}
        />

        <Clients
          clients={meta.clients}
          onChange={meta.onClientsChange}
          onAdd={meta.onAddClients}
          onRemove={meta.onRemoveClient}
          disabled={meta.insideEdit || false}
        />

        <div className="mv12">
          {meta.insideEdit && (
            <PrimaryButton
              label={meta.editButtonLabel.label}
              onClick={() => meta.setEdit(false)}
              disabled={meta.editButtonLabel.disabled}
              className="schedulerForm__editButton"
            />
          )}

          {!meta.insideEdit && (
            <PrimaryButton
              label={`${props.edit ? 'Зберегти' : 'Створити'}`}
              onClick={meta.onFormCreate}
              disabled={!meta.activeAddButton}
            />
          )}
        </div>
      </div>

      <ConfirmDialog
        open={meta.isConfirmDialogOpen}
        title={meta.confirmDialogContent.title}
        message={meta.confirmDialogContent.message}
        handleClose={meta.onConfirmDialogClose}
        handleConfirm={meta.onConfirmDialogAgreed}
      />
    </div>
  );
};

export default memo(SchedulerForm);
