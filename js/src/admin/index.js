import app from 'flarum/admin/app';
import Alert from 'flarum/common/components/Alert';

app.initializers.add('datlechin/flarum-cbox', () => {
  app.extensionData
    .for('datlechin-cbox')
    .registerSetting(function () {
      return (
        <div className="Form-group">
          <Alert dismissible={false}>{app.translator.trans('datlechin-cbox.admin.settings.description')}</Alert>
        </div>
      );
    })
    .registerSetting({
      setting: 'datlechin-cbox.secret',
      label: app.translator.trans('datlechin-cbox.admin.settings.secret'),
      type: 'text',
    })
    .registerSetting({
      setting: 'datlechin-cbox.box_id',
      label: app.translator.trans('datlechin-cbox.admin.settings.box_id'),
      type: 'text',
    })
    .registerSetting({
      setting: 'datlechin-cbox.box_tag',
      label: app.translator.trans('datlechin-cbox.admin.settings.box_tag'),
      type: 'text',
    })
    .registerSetting({
      setting: 'datlechin-cbox.show_when_user_not_login',
      label: app.translator.trans('datlechin-cbox.admin.settings.show_when_user_not_login'),
      help: app.translator.trans('datlechin-cbox.admin.settings.show_when_user_not_login_help'),
      type: 'boolean',
    });
});
